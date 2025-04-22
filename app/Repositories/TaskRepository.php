<?php

namespace App\Repositories;

use App\Enums\PriorityEnum;
use App\Models\Task;
use App\Services\Filters\SimpleQueryFilter\TaskFilter;
use App\Traits\HasUser;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\LazyCollection;

class TaskRepository implements TaskRepositoryInterface
{
    use HasUser;

    public function __construct(readonly TaskFilter $filter)
    {
    }

    public function getTasksForView(int $perPage = 10, int $page = 1): Arrayable
    {
        $user = $this->resolveUser();

        return Task::query()->getTaskForUser($user)
            ->filter($this->filter)
            ->sort(['priority', 'title', 'due_date'])
            ->paginate($perPage, page:$page);
    }

    public function getAllTasks(int $chunkSize = 100): LazyCollection//Абсолютно бесполезный метод
    {
        return Task::query()->with([])->lazy($chunkSize);
    }

    //TODO: если отношения - lazy();
    //Если это кто то читает, объясните плиз почему курсор ест больше памяти чем lazy??
    public function getOverdue(array $columns = ['*']): LazyCollection//LazyCollection а не iterable
    {
        return Task::query()
            ->select($columns)
            ->getOverdue()
            ->cursor();
    }

    public function getHighPriorityTasksDueInNext(int $minutes): LazyCollection
    {
        return Task::query()
            ->getTasksDueInNext($minutes)
            ->getByPriority(PriorityEnum::High)
            ->cursor();
    }
}
