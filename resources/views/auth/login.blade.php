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
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-4 p-3 bg-info-subtle mt-5 rounded-4">
            <h2 class="mb-4 text-center">Login Users</h2>
            <div class="div">
    <div class="row">
        <div class="col">
          @if (session('status'))
    @php
        $statusMessage = session('status');
        $alertType = Str::contains($statusMessage, ['Invalid', 'Logged out', 'not registered']) ? 'danger' : 'success';
    @endphp
    <div class="alert alert-{{ $alertType }}">
        {{ $statusMessage }}
    </div>
@endif

        </div>
    </div>
 </div>
           <div class="row  d-flex justify-content-center align-items-center">
            <div class="col-9">
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                {{-- <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror">
                    <span class="text-danger">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div> --}}
                <div class="mb-3">
                            <label class="form-label">Email or Username</label>
                            <input type="text" name="login" class="form-control @error('login') is-invalid @enderror" value="{{ old('login') }}">
                            <span class="text-danger">
                                @error('login')
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
             <div class="text-center mt-4">
                        <p>Don't have an account? 
                            <a href="{{ url('/register')  }}" class="text-decoration-none">Register here</a>
                        </p>
                    </div>

    </div>
   </div>
</body>
</html>
