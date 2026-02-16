<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRole extends Model
{
    /** @use HasFactory<\Database\Factories\UserRoleFactory> */
    use HasFactory;

    protected $fillable = [
        'role',
    ];

    public function getDisplayNameAttribute()
    {
        return [
            'teacher' => 'Преподаватель',
            'deputy'  => 'Зам. директора',
            'admin'   => 'Администратор',
        ][$this->role] ?? $this->role;
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
