<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>

@if($errors->any())
    <p style="color:red;">{{ $errors->first() }}</p>
@endif

<form method="POST" action="{{ route('login.post') }}">
    @csrf

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Login</button>
    <a href={{route('register')}}>Register</a>
</form>
</body>
</html>
