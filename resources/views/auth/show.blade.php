<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>User Details</h2>

    <ul class="list-group mb-4">
        <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
        <li class="list-group-item"><strong>Gender:</strong> {{ $user->gender }}</li>
        <li class="list-group-item"><strong>Age:</strong> {{ $user->age }}</li>
        <li class="list-group-item"><strong>Phone:</strong> {{ $user->phone }}</li>
        <li class="list-group-item"><strong>Hobbies:</strong> {{ $user->hobbies }}</li>
        <li class="list-group-item"><strong>Role:</strong> {{ $user->role }}</li>
    </ul>

    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">Edit</a>

    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>
</body>
</html>
