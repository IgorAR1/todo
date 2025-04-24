
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

        @auth
            | <span>Welcome, {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            | <a href="{{ route('login.index') }}">Login</a>
            <a href="{{ route('register.index') }}">Register</a>
        @endauth
    </nav>
    <hr>
</header>

<main>
    @yield('content')
</main>

<footer>
    <hr>
    <p>&copy; {{ date('Y') }}</p>
</footer>
</body>
</html>
