<?php

namespace App\Http\Controllers\web;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function __construct(readonly TaskService $taskService)
    {
    }

    public function index()
    {
        $tasks = $this->taskService->getTasksForView();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create', ['statuses' => TaskStatus::cases()]);
    }

    public function store(CreateTaskRequest $request)
    {
        $data = $request->validated();

        $this->taskService->createTask($data);
    }

    public function show(Task $task)
    {
        Gate::authorize('update', $task);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(int $id, UpdateTaskRequest $request)
    {
        $data = $request->validated();
        $task = Task::query()->findOrFail($id);
        Gate::authorize('update', $task);

        $this->taskService->updateTask($id, $data);
    }
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);

        $this->taskService->deleteTask($task);
    }
}
