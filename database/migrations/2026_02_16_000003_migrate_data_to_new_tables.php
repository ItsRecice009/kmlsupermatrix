<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Memindahkan data admin dan pegawai dari tabel users 
     * ke tabel admins dan pegawai yang baru
     */
    public function up(): void
    {
        // Migrate admin data from users to admins table
        $admins = DB::table('users')->where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            DB::table('admins')->insert([
                'name' => $admin->name,
                'email' => $admin->email,
                'email_verified_at' => $admin->email_verified_at,
                'password' => $admin->password,
                'is_active' => !($admin->is_blocked ?? false),
                'created_by' => $admin->approved_by,
                'approved_at' => $admin->approved_at,
                'last_login_at' => $admin->last_login_at,
                'last_login_ip' => $admin->last_login_ip,
                'remember_token' => $admin->remember_token,
                'created_at' => $admin->created_at,
                'updated_at' => $admin->updated_at,
            ]);
        }
        
        // Migrate pegawai data from users to pegawai table
        $pegawaiList = DB::table('users')->where('role', 'pegawai')->get();
        
        foreach ($pegawaiList as $peg) {
            DB::table('pegawai')->insert([
                'name' => $peg->name,
                'email' => $peg->email,
                'email_verified_at' => $peg->email_verified_at,
                'password' => $peg->password,
                'is_approved' => $peg->is_approved ?? false,
                'approved_by' => $peg->approved_by,
                'approved_at' => $peg->approved_at,
                'is_blocked' => $peg->is_blocked ?? false,
                'blocked_reason' => $peg->blocked_reason,
                'blocked_by' => $peg->blocked_by,
                'blocked_at' => $peg->blocked_at,
                'last_login_at' => $peg->last_login_at,
                'last_login_ip' => $peg->last_login_ip,
                'phone' => null,
                'address' => null,
                'remember_token' => $peg->remember_token,
                'created_at' => $peg->created_at,
                'updated_at' => $peg->updated_at,
            ]);
        }
        
        echo "\nMigrated " . count($admins) . " admin(s) to admins table\n";
        echo "Migrated " . count($pegawaiList) . " pegawai to pegawai table\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear the new tables
        DB::table('admins')->truncate();
        DB::table('pegawai')->truncate();
        
        echo "\nCleared admins and pegawai tables\n";
    }
};
