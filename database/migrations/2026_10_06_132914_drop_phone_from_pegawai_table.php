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
        if (Schema::hasColumn('pegawai', 'phone')) {
            Schema::table('pegawai', function (Blueprint $table) {
                $table->dropColumn('phone');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('pegawai', 'phone')) {
            Schema::table('pegawai', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('last_login_ip');
            });
        }
    }
};
