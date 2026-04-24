<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        "support_id",
        "user_id",
        "response",
        "read_at"
    ];

    function support(): BelongsTo
    {
        return $this->belongsTo(Support::class);
    }

    function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
