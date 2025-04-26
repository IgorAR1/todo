<?php

namespace App\Services;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use App\Services\Logger\ActivityLogger;
use App\Traits\InteractWithUser;
use DateInterval;
use DateTimeImmutable;
use Illuminate\Contracts\Auth\Authenticatable;

class TaskService
{
    use InteractWithUser;

    private Authenticatable $user;

    public function __construct(readonly ActivityLogger $logger,readonly TaskRepositoryInterface $repository)
    {
    }

    public function createTask(array $data): Task
    {
        $user = $this->resolveUser();

        $data['owner_id'] = $user->id;
        $data['due_date'] = $this->resolveExpirationDate($data);

        $task = $this->repository->create($data);

        $this->logger->log($user, 'create', $task);

        return $task;
    }

    public function updateTask(string $id, array $data): Task
    {
        $user = $this->resolveUser();

        $data['due_date'] = $this->resolveExpirationDate($data);

        $task = $this->repository->update($id, $data);

        $this->logger->log($user, 'update', $task, extra: ['changes' => $task->getChanges()]);

        return $task;
    }

    public function deleteTask(Task $task): void
    {
        $user = $this->resolveUser();

        $this->logger->log($user, 'delete', $task);

        $this->repository->delete($task);
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

        $task->setCollaborators($shares);

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
