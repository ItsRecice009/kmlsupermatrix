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
        // 1. Drop tabel anak kml_cables dan kml_placemarks
        Schema::dropIfExists('kml_cables');
        Schema::dropIfExists('kml_placemarks');

        // 2. Hapus kolom total_titik dan total_jarak dari kml_projects, serta siapkan file_path & raw_kml
        Schema::table('kml_projects', function (Blueprint $table) {
            if (Schema::hasColumn('kml_projects', 'total_titik')) {
                $table->dropColumn('total_titik');
            }
            if (Schema::hasColumn('kml_projects', 'total_jarak')) {
                $table->dropColumn('total_jarak');
            }
            if (!Schema::hasColumn('kml_projects', 'file_path')) {
                $table->string('file_path')->nullable()->after('file_name');
            }
            if (!Schema::hasColumn('kml_projects', 'raw_kml')) {
                $table->longText('raw_kml')->nullable()->after('file_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kml_projects', function (Blueprint $table) {
            $table->integer('total_titik')->default(0);
            $table->double('total_jarak', 12, 2)->default(0);
            $table->dropColumn(['file_path', 'raw_kml']);
        });

        Schema::create('kml_placemarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kml_project_id')->constrained('kml_projects')->onDelete('cascade');
            $table->string('name');
            $table->string('shape', 50)->default('triangle');
            $table->string('category', 100)->nullable();
            $table->double('lat', 12, 8);
            $table->double('lng', 12, 8);
            $table->string('fill_color', 20)->default('#EE3124');
            $table->string('outline_color', 20)->default('#FFFFFF');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('kml_cables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kml_project_id')->constrained('kml_projects')->onDelete('cascade');
            $table->string('name');
            $table->string('cable_type', 100)->nullable();
            $table->double('length_meters')->default(0);
            $table->string('color', 20)->default('#EE3124');
            $table->longText('coordinates_json')->nullable();
            $table->timestamps();
        });
    }
};
