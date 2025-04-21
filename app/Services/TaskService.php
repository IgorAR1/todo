<?php

namespace App\Services;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Traits\HasUser;
use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TaskService
{
    use HasUser;

    public function __construct()
    {}

    public function createTask(array $data): Task
    {
        $user = $this->resolveUser();

        return DB::transaction(function () use ($data, $user): Task {
            $task = new Task();
            $task->title = $data['title'];
            $task->description = $data['description'];
            $task->priority = $data['priority'];
            $task->status = $data['status'];
            $task->owner_id = $user->id;
            $task->due_date = $this->resolveExpirationDate($data);

            $task->save();

            return $task;
        });
    }

    public function updateTask(string $id, array $data): Task
    {
        return DB::transaction(function () use ($data, $id): Task {
            $task = Task::query()->lockForUpdate()->find($id);

            $task->title = array_key_exists('title', $data) ? $data['title'] : $task->title;
            $task->description = array_key_exists('description', $data) ? $data['description'] : $task->description;
            $task->priority = array_key_exists('priority', $data) ? $data['priority'] : $task->priority;
            $task->status = array_key_exists('status', $data) ? $data['status'] : $task->status;
            $task->due_date = array_key_exists('due_date', $data) ? $this->resolveExpirationDate($data) : $task->due_date;

            $task->save();

            return $task;
        });
    }

    public function deleteTask(string $id): void
    {
        Task::query()->where('id', $id)->delete();
    }

    protected function resolveExpirationDate(array $data): ?DateTimeInterface
    {
        if (isset($data['due_date'])) {
            return new DateTimeImmutable($data['due_date']);
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

    public function shareTask(Task $task, array $users): void
    {
        $users = $this->formatUsers($users);

        $task->collaborators()->sync($users);
    }

    private function formatUsers(array $users): array{

        return array_reduce($users, function (array $carry, $user) {
            $carry[$user['id']] = ['role' => $user['role']];
            return $carry;
        }, []);
    }
}
