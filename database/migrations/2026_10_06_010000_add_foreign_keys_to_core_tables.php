<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menghubungkan tabel inti: admins, pegawai, designators, kml_projects.
     *
     * admins  1 --- N pegawai       (approved_by, blocked_by)
     * admins  1 --- N designators   (admin_id)
     * admins  1 --- N kml_projects  (admin_id)
     * pegawai 1 --- N kml_projects  (pegawai_id)
     */
    public function up(): void
    {
        // 1. Bersihkan nilai yatim agar constraint dapat dibuat
        DB::statement('UPDATE pegawai SET approved_by = NULL WHERE approved_by IS NOT NULL AND approved_by NOT IN (SELECT id FROM admins)');
        DB::statement('UPDATE pegawai SET blocked_by = NULL WHERE blocked_by IS NOT NULL AND blocked_by NOT IN (SELECT id FROM admins)');

        // 2. pegawai -> admins
        Schema::table('pegawai', function (Blueprint $table) {
            $table->foreign('approved_by')->references('id')->on('admins')->nullOnDelete();
            $table->foreign('blocked_by')->references('id')->on('admins')->nullOnDelete();
        });

        // 3. designators -> admins
        Schema::table('designators', function (Blueprint $table) {
            $table->foreignId('admin_id')->nullable()->after('id')
                ->constrained('admins')->nullOnDelete();
        });

        // 4. kml_projects -> pegawai & admins
        Schema::table('kml_projects', function (Blueprint $table) {
            $table->foreignId('pegawai_id')->nullable()->after('id')
                ->constrained('pegawai')->nullOnDelete();
            $table->foreignId('admin_id')->nullable()->after('pegawai_id')
                ->constrained('admins')->nullOnDelete();
        });

        // 5. Isi data lama berdasarkan kecocokan nama pada kolom created_by
        DB::statement('UPDATE kml_projects k JOIN pegawai p ON p.name = k.created_by SET k.pegawai_id = p.id WHERE k.pegawai_id IS NULL');
        DB::statement('UPDATE kml_projects k JOIN admins a ON a.name = k.created_by SET k.admin_id = a.id WHERE k.pegawai_id IS NULL AND k.admin_id IS NULL');
    }

    public function down(): void
    {
        Schema::table('kml_projects', function (Blueprint $table) {
            $table->dropConstrainedForeignId('admin_id');
            $table->dropConstrainedForeignId('pegawai_id');
        });

        Schema::table('designators', function (Blueprint $table) {
            $table->dropConstrainedForeignId('admin_id');
        });

        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['blocked_by']);
        });
    }
};
