<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllByUserId(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Task::where('user_id', $userId)->paginate($perPage);
    }

    public function findById(int $id): ?Task
    {
        return Task::find($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): bool
    {
        return $task->update($data);
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }
}
