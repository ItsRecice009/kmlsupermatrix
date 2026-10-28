<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KmlProject extends Model
{
    use HasFactory;

    protected $table = 'kml_projects';

    protected $fillable = [
        'pegawai_id',
        'admin_id',
        'nama_project',
        'area',
        'tanggal_survei',
        'file_name',
        'file_path',
        'raw_kml',
        'data_json',
    ];

    protected $casts = [
        'tanggal_survei' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get placemarks array from data_json
     */
    public function getPlacemarksAttribute(): array
    {
        return json_decode($this->data_json, true) ?: [];
    }
}
