<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Services\TaskService;

class CreateTaskAction
{
    public function __construct(protected TaskService $service) {}

    public function execute(array $data): Task
    {
        return $this->service->createTask($data);
    }
}
