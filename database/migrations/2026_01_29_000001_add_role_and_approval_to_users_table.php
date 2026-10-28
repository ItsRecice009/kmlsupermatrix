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
            // Role: admin atau user
            $table->enum('role', ['user', 'admin'])->default('user')->after('password');
            
            // Approval system
            $table->boolean('is_approved')->default(false)->after('role');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('is_approved');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            
            // Block system
            $table->boolean('is_blocked')->default(false)->after('approved_at');
            $table->text('blocked_reason')->nullable()->after('is_blocked');
            $table->foreignId('blocked_by')->nullable()->constrained('users')->onDelete('set null')->after('blocked_reason');
            $table->timestamp('blocked_at')->nullable()->after('blocked_by');
            
            // Login tracking
            $table->timestamp('last_login_at')->nullable()->after('blocked_at');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['blocked_by']);
            
            // Drop columns
            $table->dropColumn([
                'role',
                'is_approved',
                'approved_by',
                'approved_at',
                'is_blocked',
                'blocked_reason',
                'blocked_by',
                'blocked_at',
                'last_login_at',
                'last_login_ip',
            ]);
        });
    }
};
