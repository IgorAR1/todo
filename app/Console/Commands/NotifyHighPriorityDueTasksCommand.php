<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskOverdue;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
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
    protected $description = 'Command description';

    public function __construct(readonly TaskRepository $repository)
    {
        parent::__construct();
    }

    public function handle()
    {
        $notification = new TaskOverdue();
        $expiredTasks = $this->repository->getHighPriorityTasksDueInNext(15);

        foreach ($expiredTasks as $task) {
            $task->owner->notify($notification);
        }
    }
}
