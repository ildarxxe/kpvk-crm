<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): Factory|View
    {
        $user = auth()->user();

        $query = Task::with(['teacher', 'admin']);

        if ($user->role_id === 1) {
            $query->where('teacher_id', $user->id);
        }
        elseif ($user->role_id === 2) {
        }
        elseif ($user->role_id === 3) {
            $query->whereIn('status', ['in_progress', 'completed'])
                ->where('admin_id', $user->id);
        }

        $tasks = $query->latest()->get();

        $user = auth()->user();
        $userRole = $user->role->role;
        $admins = User::query()->where('role_id', 3)->get();
        $priorities = TaskPriority::all();

        return view('dashboard', [
            'tasks' => $tasks,
            'tasksCount' => $tasks->count()
        ])->with(['user' => $user, 'admins' => $admins, 'userRole' => $userRole, 'priorities' => $priorities]);
    }
}
