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
        // Drop tabel filters (fitur sudah dihapus)
        Schema::dropIfExists('filters');
        
        // Drop tabel routing_* (tidak digunakan oleh sistem)
        Schema::dropIfExists('routing_cables');
        Schema::dropIfExists('routing_designators');
        Schema::dropIfExists('routing_placemarks');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate filters table
        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori')->unique();
            $table->text('pattern');
            $table->timestamps();
        });

        // Recreate routing tables (if needed for rollback)
        Schema::create('routing_cables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('routing_designators', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('routing_placemarks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};
