<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportFile extends Model
{
    protected $fillable = [
        'support_id',
        'file_path',
        'file_name',
    ];
}
