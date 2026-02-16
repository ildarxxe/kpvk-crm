<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function moderate(User $user, Task $task): bool
    {
        return $user->role->role === 'deputy' && $task->status === 'pending';
    }

    public function decline(User $user, Task $task): bool
    {
        return $user->role->role === 'deputy' && $task->status === 'pending';
    }

    public function complete(User $user, Task $task): bool
    {
        return $user->role->role === 'admin'
            && $task->status === 'in_progress'
            && $task->admin_id === $user->id;
    }
}
