<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>403 Forbidden</title>
    <style>
        body {
            font-family: system-ui, sans-serif;
            background: #f8fafc;
            color: #1a202c;
            text-align: center;
            padding-top: 10%;
        }
        h1 {
            font-size: 5rem;
            margin-bottom: 0.5rem;
        }
        p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }
        a {
            text-decoration: none;
            background: #1d4ed8;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }
        a:hover {
            background: #2563eb;
        }
    </style>
</head>
<body>
<h1>403</h1>
<p>You don’t have permission to access this page.</p>
<a href="{{ url()->previous() }}">← Go back</a>
</body>
</html>
