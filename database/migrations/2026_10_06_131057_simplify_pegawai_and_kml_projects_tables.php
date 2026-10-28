<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Hapus email_verified_at dari tabel pegawai jika ada
        if (Schema::hasColumn('pegawai', 'email_verified_at')) {
            Schema::table('pegawai', function (Blueprint $table) {
                $table->dropColumn('email_verified_at');
            });
        }

        // 2. Hapus created_by dari tabel kml_projects jika ada
        if (Schema::hasColumn('kml_projects', 'created_by')) {
            Schema::table('kml_projects', function (Blueprint $table) {
                $table->dropColumn('created_by');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('pegawai', 'email_verified_at')) {
            Schema::table('pegawai', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            });
        }

        if (!Schema::hasColumn('kml_projects', 'created_by')) {
            Schema::table('kml_projects', function (Blueprint $table) {
                $table->string('created_by')->nullable()->after('data_json');
            });
        }
    }
};
