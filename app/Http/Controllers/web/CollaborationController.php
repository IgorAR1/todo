<?php

namespace App\Http\Controllers\web;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CollaboratorsRequest;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;

class CollaborationController extends Controller
{
    public function __construct(readonly TaskService $taskService)
    {
    }

    public function index(Task $task)
    {
        $users =  User::query()->simplePaginate(10);
        $roles = RoleEnum::cases();

        return view('tasks.collaborations.index', compact('users', 'task', 'roles'));
    }

    public function shareTask(Task $task, CollaboratorsRequest $request)
    {
        $data = $request->validated();

        $this->taskService->shareTask($task, $data['shares']);

        return redirect()->route('tasks.show', ['task' => $task]);
    }
}
