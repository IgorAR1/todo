<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<h2>Register</h2>

@if($errors->any())
    <p style="color:red;">{{ $errors->first() }}</p>
@endif
<form method="POST" action="{{ route('register') }}">
    @csrf

    <label>Name:</label><br>
    <input type="text" name="name"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <label>Confirm Password:</label><br>
    <input type="password" name="password_confirmation"><br><br>

    <button type="submit">Register</button>
</form>
</body>
</html>
