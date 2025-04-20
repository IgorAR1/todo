<?php

namespace App\Http\Controllers\web;

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
        $users =  User::all()->except(Auth::id());

        return view('tasks.collaborations_index', compact('users', 'task'));
    }

    public function shareTask(Task $task, CollaboratorsRequest $request)
    {
        $data = $request->validated();

        $this->taskService->shareTask($task, $data['users']);

        return redirect()->back();
    }
}
