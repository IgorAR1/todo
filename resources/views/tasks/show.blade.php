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
            <li><strong>Priority:</strong> {{ \App\Enums\PriorityEnum::from($task->priority)->name ?? '—' }}</li>
            <li><strong>Description:</strong> {{ $task->description ?? 'No description' }}</li>
            <li><strong>Tags:</strong>
                @if ($task->tags->isNotEmpty())
                    @foreach ($task->tags as $tag)
                        <span style="background: #eee; padding: 2px 6px; margin-right: 4px;">{{ $tag->name }}</span>
                    @endforeach
                @else
                    <em>—</em>
                @endif
            </li>
            <li><strong>Created:</strong> {{ $task->created_at->toDayDateTimeString() }}</li>
            <li><strong>Updated:</strong> {{ $task->updated_at->toDayDateTimeString() }}</li>
        </ul>

        {{-- Collaborators --}}
        <div style="margin-top: 30px;">
            <h3>👥 Collaborators</h3>
            @if ($task->collaborators->isNotEmpty())
                <ul>
                    @foreach ($task->collaborators as $user)
                        <li>
                            {{ $user->name }} ({{ $user->email }}) — <em>{{ $user->pivot->role }}</em>
                        </li>
                    @endforeach
                </ul>
            @else
                <p><em>No collaborators assigned.</em></p>
            @endif
            <form action="{{ route('tasks.collaboration', $task->id) }}" method="GET" style="display:inline;">
                <button type="submit">Share</button>
            </form>
        </div>

        {{-- Activity Log --}}
        <div style="margin-top: 30px;">
            <h3>📜 Activity Log</h3>
            @if ($task->activities->isNotEmpty())
                <ul>
                    @foreach ($task->activities as $activity)
                        <li>
                            <strong>{{ $activity->user->name ?? 'System' }}</strong>
                            <span>{{ $activity->action }}</span>
                            @if ($activity->description)
                                — {{ $activity->description }}
                            @endif
                            <br>
                            <small style="color: #888;">{{ \Carbon\Carbon::parse($activity->date_time)->diffForHumans() }}</small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p><em>No activity recorded for this task.</em></p>
            @endif
        </div>

        <div style="margin-top: 30px;">
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
