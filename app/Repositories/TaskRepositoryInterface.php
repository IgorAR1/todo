<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\LazyCollection;

interface TaskRepositoryInterface
{
    public function create(array $data): Task;

    public function update(string $id, array $data): Task;

    public function delete(Task $task): void;

    public function getTasksForView(int $perPage = 10, int $page = 1): Arrayable;

    public function getAllTasks(int $chunkSize = 100): LazyCollection;

    public function getOverdue(array $columns = ['*']): LazyCollection;

    public function getHighPriorityTasksDueInNext(int $minutes): LazyCollection;
}
