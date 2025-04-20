<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Task Manager')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header>
    <h1>Task Manager</h1>
    <nav>
        <a href="{{ route('tasks.index') }}">All Tasks</a> |
        <a href="{{ route('tasks.create') }}">New Task</a>
    </nav>
    <hr>
</header>

<main>
    @yield('content')
</main>

<footer>
    <hr>
    <p>&copy; {{ date('Y') }} Your App</p>
</footer>
</body>
</html>
