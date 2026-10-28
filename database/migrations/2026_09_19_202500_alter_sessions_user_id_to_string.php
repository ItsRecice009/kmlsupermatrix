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
        if (Schema::hasTable('sessions') && DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE sessions MODIFY user_id VARCHAR(255) NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('sessions')) {
            DB::statement('ALTER TABLE sessions MODIFY user_id BIGINT UNSIGNED NULL');
        }
    }
};
