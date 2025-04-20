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
                    @foreach (['pending', 'in_progress', 'done', 'canceled', 'overdue'] as $status)
                        <option value="{{ $status }}" {{ old('status', $task->status) === $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
                @error('status') <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="ttl">TTL (in days):</label>
                <input type="number" name="ttl" id="ttl" value="{{ old('ttl') }}">
                @error('ttl') <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="due_date">Due Date:</label>
                <input type="date" name="due_date" id="due_date"
                       value="{{ old('due_date', optional($task->due_date)->format('Y-m-d')) }}">
                @error('due_date') <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <button type="submit">Update Task</button>
        </form>
    </div>
@endsection
