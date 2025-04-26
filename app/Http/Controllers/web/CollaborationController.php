<?php

namespace App\Http\Controllers\web;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CollaboratorsRequest;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CollaborationController extends Controller
{
    public function __construct(readonly TaskService $taskService)
    {
    }

    public function index(Task $task)
    {
        $users = User::query()
            ->whereNot('id', $task->owner_id)
            ->simplePaginate(10);

        $roles = RoleEnum::cases();

        return view('tasks.collaborations.index', compact('users', 'task', 'roles'));
    }

    public function share(Task $task, CollaboratorsRequest $request)
    {
        $data = $request->validated();
        $this->taskService->shareTask($task, $data['shares']);

        return redirect()->route('tasks.show', ['task' => $task]);
    }
}
