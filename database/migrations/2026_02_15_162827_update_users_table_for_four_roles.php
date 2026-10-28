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
        Schema::table('users', function (Blueprint $table) {
            // Update role enum to include 4 roles
            // Drop the old enum and create new one
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            // Add new role enum with 4 roles
            $table->enum('role', ['user_umum', 'pegawai', 'admin', 'super_admin'])
                ->default('pegawai')
                ->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            // Restore old role enum
            $table->enum('role', ['user', 'admin'])
                ->default('user')
                ->after('password');
        });
    }
};
