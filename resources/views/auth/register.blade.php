<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="mb-4 mt-4">
            <h1>User Register</h1>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('user.store') }}">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Enter Your Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label for="useremail" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div class="mb-3">
                <label for="usergender" class="form-label">Gender</label>
                <select name="gender" class="form-select">
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="mb-3 ">
                <label class="form-label" for="userage">Enter Your Age</label>
                <input type="number" name="age" class="form-control" value="{{ old('age') }}">
            </div>
            <div class="mb-3 ">
                <label class="form-label" for="userphone">Enter Phone Number</label>
                <input type="number" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
            <div class="mb-3 ">
                <label class="form-label" for="userhobbies">Yours Hobbies: </label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hobbies[]" value="Cricket"
                        {{ is_array(old('hobbies')) && in_array('Cricket', old('hobbies')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="">Cricket</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hobbies[]" value="Coding"
                        {{ is_array(old('hobbies')) && in_array('Coding', old('hobbies')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="">Coding</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hobbies[]" value="Reading"
                        {{ is_array(old('hobbies')) && in_array('Reading', old('hobbies')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="">Reading</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="userpassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="userconfirmpassword" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="text-center mt-4">
            <p>Already Registered ?
                <a href="{{ route('login') }}" class="text-decoration-none">Login here</a>
            </p>
        </div>
    </div>
</body>

</html>
