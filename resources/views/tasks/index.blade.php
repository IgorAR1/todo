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
                        <td>{{ $task->owner_id ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('tasks.show', $task->id) }}">View</a> |
                            <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
