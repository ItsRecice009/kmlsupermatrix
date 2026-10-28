<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah role super_admin yang ada menjadi admin
        DB::table('users')->where('role', 'super_admin')->update(['role' => 'admin']);

        // 2. Ubah role user_umum atau user lama yang ada menjadi pegawai
        DB::table('users')->whereIn('role', ['user_umum', 'user'])->update(['role' => 'pegawai']);

        // 3. Pastikan semua akun berstatus approved (aktif)
        if (Schema::hasColumn('users', 'is_approved')) {
            DB::table('users')->update(['is_approved' => true]);
        }

        // 4. Ubah tipe kolom role pada tabel users menjadi ENUM('admin', 'pegawai')
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'pegawai') NOT NULL DEFAULT 'pegawai'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user_umum', 'pegawai', 'admin', 'super_admin') NOT NULL DEFAULT 'pegawai'");
    }
};
