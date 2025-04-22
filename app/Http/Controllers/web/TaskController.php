<?php

namespace App\Http\Controllers\web;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Tag;
use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use App\Services\Logger\ActivityLogger;
use App\Services\TaskService;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function __construct(readonly TaskService $service, readonly TaskRepositoryInterface $repository)
    {
    }

    public function index()
    {
        $tasks = $this->repository->getTasksForView();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $tags = Tag::all();

        return view('tasks.create', ['statuses' => TaskStatus::cases(), 'priorities' => PriorityEnum::cases(),'tags' => $tags]);
    }

    public function store(CreateTaskRequest $request)
    {
        $data = $request->validated();

        $this->service->createTask($data);

        return redirect()->route('tasks.index');
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

        $this->service->updateTask($id, $data);
    }

    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);

        $this->service->deleteTask($task);

        return redirect()->route('tasks.index');
    }
}
