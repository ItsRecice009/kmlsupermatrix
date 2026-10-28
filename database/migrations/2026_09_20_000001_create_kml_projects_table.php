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
        Schema::create('kml_projects', function (Blueprint $table) {
            $table->id();
            $table->string('nama_project');
            $table->string('area')->nullable();
            $table->string('file_name')->nullable();
            $table->integer('total_titik')->default(0);
            $table->double('total_jarak', 12, 2)->default(0); // dalam meter
            $table->longText('data_json')->nullable(); // JSON koordinat & placemark
            $table->string('status')->default('draft'); // 'draft', 'validated', 'exported'
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kml_projects');
    }
};
