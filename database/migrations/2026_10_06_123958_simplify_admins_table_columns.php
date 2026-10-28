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
        Schema::table('admins', function (Blueprint $table) {
            $columnsToDrop = [];
            foreach (['email_verified_at', 'is_active', 'created_by', 'approved_at'] as $col) {
                if (Schema::hasColumn('admins', $col)) {
                    $columnsToDrop[] = $col;
                }
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->boolean('is_active')->default(true)->after('password');
            $table->unsignedBigInteger('created_by')->nullable()->after('is_active');
            $table->timestamp('approved_at')->nullable()->after('created_by');
        });
    }
};
