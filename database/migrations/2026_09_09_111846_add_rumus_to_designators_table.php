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
        Schema::table('designators', function (Blueprint $table) {
            $table->text('rumus')->nullable()->after('nama_designator');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designators', function (Blueprint $table) {
            $table->dropColumn('rumus');
        });
    }
};
