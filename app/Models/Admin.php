<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
        'last_login_ip',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthIdentifier()
    {
        return 'admin_' . $this->getKey();
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'approved_by');
    }

    public function designators()
    {
        return $this->hasMany(DesignatorModel::class, 'admin_id');
    }

    public function kmlProjects()
    {
        return $this->hasMany(KmlProject::class, 'admin_id');
    }

    /**
     * Role accessor for compatibility
     */
    public function getRoleAttribute(): string
    {
        return 'admin';
    }

    /**
     * is_blocked accessor for compatibility with middleware/views
     */
    public function getIsBlockedAttribute(): bool
    {
        return false;
    }

    public function isAdmin(): bool
    {
        return true;
    }

    public function canManageDesignators(): bool
    {
        return true;
    }
}
