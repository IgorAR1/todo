@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create New Task</h2>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div>
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required>
                @error('title')
                <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="description">Description:</label>
                <textarea name="description" id="description">{{ old('description') }}</textarea>
                @error('description')
                <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="status">Status:</label>
                <select name="status" id="status">
                    @foreach($statuses as $status)
                        <option value={{$status->value}}>{{$status->name}}</option>
                    @endforeach
                </select>
                @error('status')
                <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="priority">Priority:</label>
                <select name="priority" id="priority">
                    @foreach($priorities as $priority)
                        <option value={{$priority->value}}>{{$priority->name}}</option>
                    @endforeach
                </select>

                @error('priority')
                <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="tags">Tags:</label><br>

                @foreach ($tags as $tag)
                    <label>
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                        {{ $tag->name }}
                    </label><br>
                @endforeach
            </div>


            <div>
                <label for="ttl">TTL (in days):</label>
                <input type="number" name="ttl" id="ttl" value="{{ old('ttl') }}">
                @error('ttl')
                <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="due_date">Due Date:</label>
                <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}">
                @error('due_date')
                <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <button type="submit">Create Task</button>
        </form>
    </div>
@endsection
