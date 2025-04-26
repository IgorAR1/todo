<?php

namespace App\Console\Commands;

use App\Enums\TaskStatus;
use App\Repositories\EloquentTaskRepository;
use App\Repositories\TaskRepositoryInterface;
use App\Services\TaskService;
use Illuminate\Console\Command;

class ChangeStatusForOverdueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspect:overdue-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(readonly TaskRepositoryInterface $repository, readonly TaskService $service)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueTasks = $this->repository->getOverdue();

        foreach ($overdueTasks as $task) {
            $this->service->changeStatus($task,TaskStatus::Overdue);
        }
    }
}
