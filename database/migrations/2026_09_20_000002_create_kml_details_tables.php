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
        // 1. Tabel Detail Titik Placemark KML
        Schema::create('kml_placemarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kml_project_id')->constrained('kml_projects')->onDelete('cascade');
            $table->string('name');
            $table->string('shape', 50)->default('triangle'); // triangle, donut, square
            $table->string('category', 100)->nullable();
            $table->double('lat', 12, 8);
            $table->double('lng', 12, 8);
            $table->string('fill_color', 20)->default('#EE3124');
            $table->string('outline_color', 20)->default('#FFFFFF');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['kml_project_id', 'shape']);
        });

        // 2. Tabel Detail Kabel / Bentang Optik KML
        Schema::create('kml_cables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kml_project_id')->constrained('kml_projects')->onDelete('cascade');
            $table->string('name');
            $table->string('cable_type', 100)->nullable(); // e.g. Kabel Distribusi, Feeder
            $table->double('length_meters')->default(0);
            $table->string('color', 20)->default('#EE3124');
            $table->longText('coordinates_json')->nullable(); // array of [{lat, lng}]
            $table->timestamps();

            $table->index('kml_project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kml_cables');
        Schema::dropIfExists('kml_placemarks');
    }
};
