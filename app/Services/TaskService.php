<?php

namespace App\Services;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Services\Logger\ActivityLogger;
use App\Traits\InteractWithUser;
use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TaskService
{
    use InteractWithUser;

    private Authenticatable $user;

    public function __construct(readonly ActivityLogger $logger)
    {
    }

    public function createTask(array $data): Task
    {
        $user = $this->resolveUser();

        $task = DB::transaction(function () use ($data, $user): Task {
            $task = new Task();
            $task->title = $data['title'] ?? null;
            $task->description = $data['description'] ?? null;
            $task->priority = $data['priority'] ?? null;
            $task->status = $data['status'] ?? null;
            $task->owner_id = $user->id;
            $task->due_date = $this->resolveExpirationDate($data);

            $task->save();

            $task->tags()->sync($data['tags'] ?? []);

            return $task;
        });

        $this->logger->log($user, 'create', $task);

        return $task;
    }

    public function updateTask(string $id, array $data): Task
    {
        $user = $this->resolveUser();

        $task = DB::transaction(function () use ($data, $id, $user): Task {
            $task = Task::query()->lockForUpdate()->find($id);

            $task->title = array_key_exists('title', $data) ? $data['title'] : $task->title;
            $task->description = array_key_exists('description', $data) ? $data['description'] : $task->description;
            $task->priority = array_key_exists('priority', $data) ? $data['priority'] : $task->priority;
            $task->status = array_key_exists('status', $data) ? $data['status'] : $task->status;
            $task->due_date = array_key_exists('due_date', $data) || array_key_exists('ttl', $data)
                ? $this->resolveExpirationDate($data)
                : $task->due_date;
            $task->tags()->sync($data['tags'] ?? []);

            $task->save();

            return $task;
        });

        $this->logger->log($user, 'update', $task, extra: ['changes' => $task->getChanges()]);

        return $task;
    }

    public function deleteTask(Task $task): void
    {
        $user = $this->resolveUser();

        $this->logger->log($user, 'delete', $task);

        $task->delete();
    }

    protected function resolveExpirationDate(array $data): ?DateTimeImmutable
    {
        if (isset($data['due_date'])) {
            return (new DateTimeImmutable($data['due_date']));
        } elseif (isset($data['ttl'])) {
            return (new DateTimeImmutable())->add(new DateInterval('PT' . intval($data['ttl']) . 'S'));

        }

        return null;
    }

    public function changeStatus(Task $task, TaskStatus $status): void
    {
        $task->status = $status->value;

        $task->save();
    }

    public function shareTask(Task $task, array $shares): void
    {
        $user = $this->resolveUser();

        $shares = $this->normalizeShares($shares);

        $task->collaborators()->sync($shares);

        $this->logger->log($user, 'share', $task, extra: ['With users:' => $shares]);
    }

    private function normalizeShares(array $shares): array
    {
        return array_reduce($shares, function (array $carry, $user) {
            $carry[$user['user_id']] = ['role' => $user['user_role']];
            return $carry;
        }, []);
    }
}
