<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function show(User $user, Task $task)
    {
        return $user->hasPermissionsForTask($task, "view");
    }

    public function update(User $user, Task $task)
    {
        return $user->hasPermissionsForTask($task, "update");
    }
}
