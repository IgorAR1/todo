<?php

namespace App\Console\Commands;

use App\Notifications\TaskOverdue;
use App\Repositories\EloquentTaskRepository;
use Illuminate\Console\Command;

class NotifyHighPriorityDueTasksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:duetasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for high-priority tasks due in the next 15 minutes.';

    public function __construct(readonly EloquentTaskRepository $repository)
    {
        parent::__construct();
    }

    public function handle()
    {
        $notification = new TaskOverdue();
        $expiredTasks = $this->repository->getHighPriorityTasksDueInNext(15);

        foreach ($expiredTasks as $task) {
            $task->owner?->notify($notification->forTask($task));
        }
    }
}
