@extends('layouts.app')

@section('title', 'All Tasks')

@section('content')
    <div class="container">
        <h2>All Tasks</h2>

        @if (session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif

        <select id="sort-select" name="sort">
            <option value="">Sort by</option>
            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
            <option value="status" {{ request('sort') == 'priority' ? 'selected' : '' }}>Priority</option>
            <option value="created_at" {{ request('sort') == 'due_date' ? 'selected' : '' }}>Due date</option>
        </select>

        <script>
            document.getElementById('sort-select').addEventListener('change', function () {
                const selected = this.value;

                const url = new URL(window.location.href);
                url.searchParams.set('sort', selected);
                url.searchParams.delete('page');

                window.location.href = url.toString();
            });
        </script>

        @if ($tasks->isEmpty())
            <p>No tasks found.</p>
        @else
            <table border="1" cellpadding="8" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Owner</th>
                    <th>Priority</th>
                    <th>Tags</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $task->status)) }}</td>
                        <td>{{ $task->due_date ?? '—' }}</td>
                        <td>{{ $task->owner->name ?? 'N/A' }}</td>
                        <td>{{ \App\Enums\PriorityEnum::from($task->priority)->name ?? 'N/A' }}</td>
                        <td>
                            @if($task->tags->isNotEmpty())
                                {{ $task->tags->pluck('name')->join(', ') }}
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('tasks.show', $task->id) }}">View</a> |
                            <a href="{{ route('tasks.edit', $task->id) }}">Edit</a> |
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this task?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div style="margin-top: 20px;">
                {{ $tasks->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
