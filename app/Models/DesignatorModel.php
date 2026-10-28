<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignatorModel extends Model
{
    // PENTING: Tentukan nama tabel secara eksplisit
    protected $table = 'designators';

    // Primary key
    protected $primaryKey = 'id';

    // Aktifkan timestamps (sesuai migration)
    public $timestamps = true;

    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'admin_id',
        'nama_designator',
        'rumus'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // Kolom yang tidak boleh diisi mass assignment
    protected $guarded = [
        'id'
    ];
}