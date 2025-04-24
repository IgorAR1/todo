<?php

namespace App\Repositories;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\LazyCollection;

interface TaskRepositoryInterface
{
    public function getTasksForView(int $perPage = 10, int $page = 1): Arrayable;

    public function getAllTasks(int $chunkSize = 100): LazyCollection;

    public function getOverdue(array $columns = ['*']): LazyCollection;

    public function getHighPriorityTasksDueInNext(int $minutes): LazyCollection;
}
