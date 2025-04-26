<?php

namespace App\Repositories;

use App\Enums\PriorityEnum;
use App\Models\Task;
use App\Services\Filters\SimpleQueryFilter\TaskFilter;
use App\Traits\InteractWithUser;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    use InteractWithUser;

    public function __construct(readonly TaskFilter $filter)
    {
    }

    public function create(array $data): Task
    {
        return DB::transaction(function () use ($data): Task {
            $task = new Task();

            $task->title = $data['title'] ?? null;
            $task->description = $data['description'] ?? null;
            $task->priority = $data['priority'] ?? null;
            $task->status = $data['status'] ?? null;
            $task->owner_id = $data['owner_id'];
            $task->due_date = $data['due_date'];

            $task->save();

            $task->tags()->sync($data['tags'] ?? []);

            return $task;
        });
    }

    public function update(string $id, array $data): Task
    {
        return DB::transaction(function () use ($data, $id): Task {
            $task = Task::query()->lockForUpdate()->find($id);

            $task->title = array_key_exists('title', $data) ? $data['title'] : $task->title;
            $task->description = array_key_exists('description', $data) ? $data['description'] : $task->description;
            $task->priority = array_key_exists('priority', $data) ? $data['priority'] : $task->priority;
            $task->status = array_key_exists('status', $data) ? $data['status'] : $task->status;
            $task->due_date = array_key_exists('due_date', $data) || array_key_exists('ttl', $data)
                ? $data['due_date']
                : $task->due_date;
            $task->tags()->sync($data['tags'] ?? []);

            $task->save();

            return $task;
        });
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }

    public function getTasksForView(int $perPage = 10, int $page = 1): Paginator
    {
        $user = $this->resolveUser();

        return Task::query()
            ->forUser($user)
            ->filter($this->filter)
            ->sort(['priority', 'title', 'due_date'])
            ->simplePaginate($perPage, page: $page);
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
