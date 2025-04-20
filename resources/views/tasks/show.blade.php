@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
    <div class="container">
        <h2>Task: {{ $task->title }}</h2>

        <ul>
            <li><strong>ID:</strong> {{ $task->id }}</li>
            <li><strong>Owner:</strong> {{ $task->owner->name ?? 'N/A' }}</li>
            <li><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $task->status)) }}</li>
            <li><strong>Due Date:</strong> {{ $task->due_date ?? '—' }}</li>
            <li><strong>Description:</strong> {{ $task->description ?? 'No description' }}</li>
            <li><strong>Created:</strong> {{ $task->created_at->toDayDateTimeString() }}</li>
            <li><strong>Updated:</strong> {{ $task->updated_at->toDayDateTimeString() }}</li>
        </ul>

        <div style="margin-top: 20px;">
            <a href="{{ route('tasks.edit', $task->id) }}">✏️ Edit</a> |
            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')">🗑️ Delete</button>
            </form> |
            <a href="{{ route('tasks.index') }}">🔙 Back to list</a>
        </div>
    </div>
@endsection
