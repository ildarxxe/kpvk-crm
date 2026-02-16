<?php
namespace App\Http\Controllers;

use App\Actions\Task\StatusTaskAction;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function __construct(
        private StatusTaskAction $action
    ) {}

    public function approve(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id,role_id,3',
            'priority_id' => 'required|exists:task_priorities,id'
        ]);
        $task = Task::query()->findOrFail($id);

        if (!auth()->user()->isDeputy()) {
            return back()->with('error', 'У вас нет прав на это действие');
        }
        $task->update([
            'status' => 'in_progress',
            'admin_id' => $request->admin_id,
            'priority_id' => $request->priority_id,
            "approved_at" => now()
        ]);
        return back()->with('success', 'Задача одобрена и назначена администратору');
    }

    public function complete(int $id): RedirectResponse
    {
        try {
            $this->action->execute($id, 'complete');
            return back()->with('success', 'Задача успешно завершена!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function decline(int $id): RedirectResponse
    {
        try {
            $this->action->execute($id, 'decline');
            return back()->with('success', 'Задача отклонена.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
