<?php

namespace App\Observers;

use App\Models\Task;
use App\Services\Logger\ActivityLogger;

class TaskObserver
{
    //Todo: Наблюдатель реагирует на фабрики
    public function __construct(readonly ActivityLogger $logger)
    {
    }

    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
//        $this->logger->log(auth()->user(), 'created', $task);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
//        $this->logger->log(auth()->user(), 'updated', $task, extra: ['changes' => $task->getChanges()]);
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
//        $this->logger->log(auth()->user(), 'deleted', $task);
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
