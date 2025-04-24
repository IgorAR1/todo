@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <div class="container">
        <h2>Edit Task</h2>

        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div>
                <label for="title">Title:</label>
                <input type="text" name="title" id="title"
                       value="{{ old('title', $task->title) }}">
                @error('title') <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="description">Description:</label>
                <textarea name="description" id="description">{{ old('description', $task->description) }}</textarea>
                @error('description') <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="status">Status:</label>
                <select name="status" id="status">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}"
                            {{ old('status', $task->status) === $status->value ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $status->value)) }}
                        </option>
                    @endforeach
                </select>
                @error('status') <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="priority">Priority:</label>
                <select name="priority" id="priority">
                    @foreach ($priorities as $priority)
                        <option value="{{ $priority->value }}"
                            {{ old('priority', $task->priority) === $priority->name ? 'selected' : '' }}>
                            {{ ucfirst($priority->name) }}
                        </option>
                    @endforeach
                </select>
                @error('priority') <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label>Tags:</label>
                @foreach ($tags as $tag)
                    <label style="margin-right: 10px;">
                        <input type="checkbox" name="tags[]"
                               value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tags', $task->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                        {{ $tag->name }}
                    </label>
                @endforeach
                @error('tags') <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="ttl">TTL (in seconds):</label>
                <input type="number" name="ttl" id="ttl" value="{{ old('ttl') }}">
                @error('ttl') <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="due_date">Due Date & Time:</label>
                <input type="datetime-local" name="due_date" id="due_date"
                       value="{{ old('due_date', optional($task->due_date)->format('Y-m-d H:i')) }}">
                @error('due_date') <div style="color:red;">{{ $message }}</div> @enderror
            </div>


            <button type="submit">Update Task</button>
        </form>
    </div>
@endsection
