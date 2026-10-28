<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kml_projects', function (Blueprint $table) {
            // Tambahkan kolom tanggal_survei jika belum ada
            if (!Schema::hasColumn('kml_projects', 'tanggal_survei')) {
                $table->date('tanggal_survei')->nullable()->after('area');
            }
        });

        // Backfill tanggal_survei dari created_at untuk data yang sudah ada
        DB::statement("UPDATE kml_projects SET tanggal_survei = DATE(created_at) WHERE tanggal_survei IS NULL");

        // Hapus kolom status jika ada
        Schema::table('kml_projects', function (Blueprint $table) {
            if (Schema::hasColumn('kml_projects', 'status')) {
                $table->dropColumn('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kml_projects', function (Blueprint $table) {
            if (!Schema::hasColumn('kml_projects', 'status')) {
                $table->string('status')->default('validated')->after('data_json');
            }
            if (Schema::hasColumn('kml_projects', 'tanggal_survei')) {
                $table->dropColumn('tanggal_survei');
            }
        });
    }
};
