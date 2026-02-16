<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;

class User extends Authenticatable implements LdapAuthenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AuthenticatesWithLdap;

    protected $fillable = [
        'name',
        'phone',
        'password',
        'role_id',
        "cabinet_number",
        "email",
        "guid",
        "domain"
    ];

    protected $hidden = [
        'password',
    ];
    
    protected static function booted()
    {
        static::saving(function ($user) { // Используем saving вместо creating
            if (empty($user->role_id)) {
                $user->role_id = 1; 
            }
    
            if (empty($user->email)) {
                $login = $user->name ?: 'user_' . $user->guid;
                $user->email = strtolower($login) . '@kpvk.loc';
            }
        });
    }
    
    public function role(): BelongsTo {
        return $this->belongsTo(UserRole::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'teacher_id');
    }

    public function tasksAsAdmin(): HasMany
    {
        return $this->hasMany(Task::class, 'admin_id');
    }

    public function userRole(): BelongsTo
    {
        return $this->belongsTo(UserRole::class);
    }

    public function isAdmin(): bool
    {
        return $this->role_id === 3;
    }

    public function isTeacher(): bool
    {
        return $this->role_id === 1;
    }

    public function isDeputy()
    {
        return $this->role_id === 2;
    }
}
