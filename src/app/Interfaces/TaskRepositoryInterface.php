<?php

namespace App\Interfaces;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface
{
    public function getAllByUserId(int $userId): LengthAwarePaginator;

    public function findById(int $id): ?Task;

    public function create(array $data): Task;

    public function update(Task $task, array $data): bool;

    public function delete(Task $task): bool;
}
