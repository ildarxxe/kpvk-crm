<?php

namespace App\Http\Controllers;

use App\Actions\Task\CreateTaskAction;
use App\Exports\TasksExport;
use App\Models\Task;
use App\Services\TaskService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $service
    ) {}

    public function viewCreate(): View
    {
        return view('tasks.create');
    }

    public function viewExport(): \Illuminate\Contracts\View\Factory|View|RedirectResponse
    {
        if (auth()->user()->role->role === "deputy") {
            return view('tasks.export');
        }
        return redirect('/');
    }

    public function generate(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse|RedirectResponse
    {
        if (auth()->user()->role_id !== 2) {
            return redirect()->back();
        }
        $from = $request->input('date_from');
        $to = $request->input('date_to');
        $query = Task::query();

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        if ($query->count() === 0) {
            return back()->withErrors(['from_to' => 'За указанный период задачи не найдены.']);
        }

        $fileName = 'tasks_report_' . now()->format('d_m_Y_H_i') . '.xlsx';

        return Excel::download(
            new TasksExport($from, $to),
            $fileName
        );
    }

    public function showTaskDetails(int $id): \Illuminate\Contracts\View\Factory|View|RedirectResponse
    {
        $task = $this->service->find($id);
        
        $user = auth()->user();
        $canView = $user->isDeputy() 
            || $user->id === $task->teacher_id 
            || $user->id === $task->admin_id;

        if (!$canView) {
            return redirect()->back()->withErrors(['error' => 'У вас нет прав для просмотра этой задачи']);
        }

        $admins = \App\Models\User::query()->where('role_id', 3)->get();
        $priorities = \App\Models\TaskPriority::all();

        return view('tasks.details', compact('task', 'admins', 'priorities'));
    }

    public function create(Request $request, CreateTaskAction $action): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachments.*' => 'nullable|file|max:20480',
        ]);

        $data['attachments'] = $request->file('attachments');
        $data['teacher_id'] = $request->user()->id;

        $action->execute($data);

        return redirect()->route('dashboard')->with('success', 'Заявка создана!');
    }
}
