<?php

namespace App\Repositories;

use App\Enums\PriorityEnum;
use App\Models\Task;
use App\Traits\HasUser;
use Illuminate\Contracts\Support\Arrayable;

class TaskRepository implements TaskRepositoryInterface
{
    use HasUser;

    public function getTasksForView(int $limit = 10, int $page = 1): Arrayable
    {
        $user = $this->resolveUser();

        return Task::query()->getTaskForUser($user)
            ->filter()
            ->orderBy('priority')
            ->paginate($limit,page: $page);
    }

    public function getAllTasks(int $chunkSize = 1000): iterable
    {
        yield from Task::query()->lazy($chunkSize);
    }

    public function getOverdue(): iterable
    {
        yield from Task::query()
            ->getOverdue()
            ->cursor();
    }

    public function getHighPriorityTasksDueInNext(int $minutes): iterable
    {
        yield from Task::query()
            ->getTasksDueInNext($minutes)
            ->getByPriority(PriorityEnum::High)
            ->cursor();
    }
}
