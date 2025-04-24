<?php

namespace App\Repositories;

use App\Enums\PriorityEnum;
use App\Models\Task;
use App\Services\Filters\SimpleQueryFilter\TaskFilter;
use App\Traits\InteractWithUser;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\LazyCollection;

class TaskRepository implements TaskRepositoryInterface
{
    use InteractWithUser;

    public function __construct(readonly TaskFilter $filter)
    {
    }

    public function getTasksForView(int $perPage = 10, int $page = 1): Arrayable
    {
        $user = $this->resolveUser();

        return Task::query()
            ->forUser($user)
            ->filter($this->filter)
            ->sort(['priority', 'title', 'due_date'])
            ->paginate($perPage, page:$page);
    }

    public function getAllTasks(int $chunkSize = 100): LazyCollection//бесполезный метод
    {
        return Task::query()
            ->with('collaborators', 'tags')
            ->lazy($chunkSize);
    }

    //TODO: если отношения - lazy();
    //Если это кто то читает, объясните плиз почему курсор ест больше памяти чем lazy??
    public function getOverdue(array $columns = ['*']): LazyCollection//LazyCollection а не iterable
    {
        return Task::query()
            ->select($columns)
            ->overdue()
            ->cursor();
    }

    public function getHighPriorityTasksDueInNext(int $minutes): LazyCollection
    {
        return Task::query()
            ->dueInNext($minutes)
            ->byPriority(PriorityEnum::High)
            ->cursor();
    }
}
