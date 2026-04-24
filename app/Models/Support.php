<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Support extends Model
{
    protected $fillable = [
        "topic",
        "message",
        "user_id",
        "token"
    ];

    public function files(): HasMany
    {
        return $this->hasMany(SupportFile::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
