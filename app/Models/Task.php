<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'teacher_id',
        'admin_id',
        'priority_id',
        'completed_at'
    ];

    public function getDisplayNameAttribute()
    {
        return [
            'pending' => 'В ожидании',
            'in_progress'   => 'В процессе',
            'completed'   => 'Выполнена',
            'declined'   => 'Отклонена',
        ][$this->status] ?? $this->status;
    }

    protected $casts = [
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function priority(): BelongsTo
    {
        return $this->belongsTo(TaskPriority::class, 'priority_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(TaskFile::class);
    }

    public function review(): HasOne {
        return $this->hasOne(Review::class);
    }
}
