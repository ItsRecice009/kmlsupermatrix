<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pegawai extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pegawai';

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_approved',
        'approved_by',
        'approved_at',
        'is_blocked',
        'blocked_reason',
        'blocked_by',
        'blocked_at',
        'last_login_at',
        'last_login_ip',
        'address',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthIdentifier()
    {
        return 'pegawai_' . $this->getKey();
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'approved_at' => 'datetime',
            'blocked_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_approved' => 'boolean',
            'is_blocked' => 'boolean',
        ];
    }

    public function approver()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function kmlProjects()
    {
        return $this->hasMany(KmlProject::class, 'pegawai_id');
    }

    /**
     * Role accessor for compatibility
     */
    public function getRoleAttribute(): string
    {
        return 'pegawai';
    }

    public function isAdmin(): bool
    {
        return false;
    }

    public function canManageDesignators(): bool
    {
        return true;
    }
}
