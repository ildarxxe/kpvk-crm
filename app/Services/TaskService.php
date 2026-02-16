<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class TaskService
{
    private $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find(int $id): Task
    {
        return Task::query()->with("files")->findOrFail($id);
    }

    public function getAll(): array
    {
        return $this->repository->getAll()->toArray();
    }

    public function createTask(array $data): Task
    {
        $data['status'] = 'pending';

        $task = $this->repository->create($data);

        if (isset($data['attachments']) && is_array($data['attachments'])) {
            $files = $data['attachments'];
            $uploadFolder = "tasks/{$task->id}";

            if (count($files) > 1) {
                $zipName = 'files_' . time() . '.zip';
                $zipRelativePath = "$uploadFolder/$zipName";

                Storage::disk('public')->makeDirectory($uploadFolder);
                $zipFullPath = Storage::disk('public')->path($zipRelativePath);

                $zip = new ZipArchive;
                if ($zip->open($zipFullPath, ZipArchive::CREATE) === TRUE) {
                    foreach ($files as $file) {
                        $zip->addFile($file->getRealPath(), $file->getClientOriginalName());
                    }
                    $zip->close();
                }

                $task->files()->create([
                    'file_path' => $zipRelativePath,
                    'file_name' => "задача",
                ]);
            } elseif (count($files) === 1) {
                $file = $files[0];
                $path = $file->store($uploadFolder, 'public');

                $task->files()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return $task;
    }

    public function update(int $id, array $data): array
    {
        $task = $this->repository->update($id, $data);
        return $task->toArray();
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
