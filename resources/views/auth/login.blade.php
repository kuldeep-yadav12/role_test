<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-4 p-5 bg-info-subtle mt-5 rounded-4">
            <h2 class="mb-4">Login Users</h2>
            <div class="div">
    <div class="row">
        <div class="col">
            @if (session('status'))
           <div class="div alert alert-success">
                    {{ session('status') }}
                </div>
                
            @endif
        </div>
    </div>
 </div>
           <div class="row">
            <div class="col-9">
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror">
                    <span class="text-danger">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    <span class="text-danger">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <button type="submit" class="btn btn-primary w-100">LOGIN</button>
            </form>

    </div>
   </div>
</body>
</html>
