<?php
namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    public function getAll(): Collection
    {
        return Task::all();
    }

    public function create(array $data): Task
    {
        return Task::query()->create($data);
    }

    public function update(int $id, array $data): Task
    {
        $task = Task::query()->find($id);
        $task->update($data);
        return $task;
    }

    public function delete(int $id): bool
    {
        return Task::query()->find($id)->delete();
    }
}
