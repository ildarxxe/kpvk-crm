<?php

namespace App\Actions\Task;

use App\Models\Task;
use Illuminate\Support\Facades\Gate;
use App\Services\TaskService;

class StatusTaskAction
{
    public function __construct(private TaskService $service) {}

    /**
     * @throws \Exception
     */
    public function execute(int $id, string $action): array
    {
        $task = $this->service->find($id);

        Gate::authorize($action, $task);

        $updateData = [
            'status' => $this->mapActionToStatus($action),
            "completed_at" => now()
        ];

        if ($action === 'work') {
            $updateData['admin_id'] = auth()->id();
        }

        return $this->service->update($id, $updateData);
    }

    private function mapActionToStatus(string $action): string
    {
        return match ($action) {
            'moderate' => 'in_progress',
            'complete' => 'completed',
            'decline'  => 'declined',
            default    => throw new \Exception('Неизвестное действие', 400),
        };
    }
}
