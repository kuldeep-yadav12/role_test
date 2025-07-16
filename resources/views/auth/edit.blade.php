<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Edit User</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select">
                <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Age</label>
            <input type="number" name="age" class="form-control" value="{{ old('age', $user->age) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="number" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Hobbies</label><br>
            @php
                $userHobbies = explode(',', $user->hobbies);
            @endphp

            <div class="form-check form-check-inline">
                <input type="checkbox" name="hobbies[]" value="Cricket" class="form-check-input"
                       {{ in_array('Cricket', old('hobbies', $userHobbies)) ? 'checked' : '' }}>
                <label class="form-check-label">Cricket</label>
            </div>

            <div class="form-check form-check-inline">
                <input type="checkbox" name="hobbies[]" value="Coding" class="form-check-input"
                       {{ in_array('Coding', old('hobbies', $userHobbies)) ? 'checked' : '' }}>
                <label class="form-check-label">Coding</label>
            </div>

            <div class="form-check form-check-inline">
                <input type="checkbox" name="hobbies[]" value="Reading" class="form-check-input"
                       {{ in_array('Reading', old('hobbies', $userHobbies)) ? 'checked' : '' }}>
                <label class="form-check-label">Reading</label>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('home', $user->id) }}" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
