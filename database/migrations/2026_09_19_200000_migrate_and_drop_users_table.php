<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            // 1. Sinkronisasi data admin dari users ke admins (jika belum ada)
            $adminsInUsers = DB::table('users')
                ->whereIn('role', ['admin', 'super_admin'])
                ->get();

            foreach ($adminsInUsers as $admin) {
                $exists = DB::table('admins')->where('email', $admin->email)->first();
                if (!$exists) {
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
                        'created_at' => $admin->created_at ?? now(),
                        'updated_at' => $admin->updated_at ?? now(),
                    ]);
                }
            }

            // 2. Sinkronisasi data pegawai dari users ke pegawai (jika belum ada)
            $pegawaiInUsers = DB::table('users')
                ->where('role', 'pegawai')
                ->get();

            foreach ($pegawaiInUsers as $peg) {
                $exists = DB::table('pegawai')->where('email', $peg->email)->first();
                if (!$exists) {
                    DB::table('pegawai')->insert([
                        'name' => $peg->name,
                        'email' => $peg->email,
                        'email_verified_at' => $peg->email_verified_at,
                        'password' => $peg->password,
                        'is_approved' => $peg->is_approved ?? true,
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
                        'created_at' => $peg->created_at ?? now(),
                        'updated_at' => $peg->updated_at ?? now(),
                    ]);
                }
            }
        }

        // 3. Update password razky@telkom.com menjadi Admin123! dan pastikan aktif
        if (Schema::hasTable('admins')) {
            DB::table('admins')
                ->where('email', 'razky@telkom.com')
                ->update([
                    'password' => Hash::make('Admin123!'),
                    'is_active' => 1,
                    'updated_at' => now(),
                ]);
        }

        // 4. Drop tabel users secara permanen
        Schema::dropIfExists('users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate users table if needed
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('role')->default('pegawai');
                $table->boolean('is_approved')->default(true);
                $table->foreignId('approved_by')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->boolean('is_blocked')->default(false);
                $table->text('blocked_reason')->nullable();
                $table->foreignId('blocked_by')->nullable();
                $table->timestamp('blocked_at')->nullable();
                $table->timestamp('last_login_at')->nullable();
                $table->string('last_login_ip', 45)->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }
};
