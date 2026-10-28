<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Membuat tabel pegawai untuk menyimpan data pegawai konstruksi
     * Terpisah dari tabel users untuk organisasi data yang lebih baik
     */
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Approval system
            $table->boolean('is_approved')->default(false);
            $table->foreignId('approved_by')->nullable()->comment('Admin yang approve');
            $table->timestamp('approved_at')->nullable();
            
            // Block system
            $table->boolean('is_blocked')->default(false);
            $table->text('blocked_reason')->nullable();
            $table->foreignId('blocked_by')->nullable()->comment('Admin yang block');
            $table->timestamp('blocked_at')->nullable();
            
            // Login tracking
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            
            // Additional info
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
            
            // Indexes
            $table->index('email');
            $table->index('is_approved');
            $table->index('is_blocked');
            $table->index('created_at');
            $table->index(['is_approved', 'is_blocked']); // Composite index untuk query filter
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
