<?php

namespace App\Console\Commands;

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

    public function __construct(readonly TaskService $taskService)
    {
        parent::__construct();
    }

    public function handle()
    {
        $notification = ///;
        $expiredTasks = $this->taskService->getHighPriorityTasksDueInNext(15);

        foreach ($expiredTasks as $task) {
            //Можно и ивенет пустить
            $task->owner->notify($notification);
        }
    }


}
