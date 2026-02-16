<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPriority extends Model
{
    protected $table = "task_priorities";
    protected $fillable = ["name"];

    public function getDisplayNameAttribute()
    {
        return [
            'low' => 'Низкий',
            'medium'  => 'Средний',
            'high'   => 'Высокий',
        ][$this->name] ?? $this->name;
    }
}
