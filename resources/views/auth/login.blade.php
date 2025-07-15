@include('layout')

@section('heading')
  Login Users
@endsection

@section('content')
<form action="{{ route('user') }}" method="POST">
  @csrf
<div class="mb-2">
        <label class="form-label">Username</label>
        <input type="text"  class="form-control @error('username') is-invalid @enderror" name="username">
        <span class="text-danger">
          @error('username')
            {{ $message }}
          @enderror
        </span>
      </div>

      <div class="mb-2">
        <label class="form-label">Email</label>
        <input type="email"  class="form-control @error('useremail') is-invalid @enderror" name="useremail">
        <span class="text-danger">
          @error('useremail')
            {{ $message }}
          @enderror
        </span>
      </div>

      <div class="mb-2">
        <label class="form-label">Password</label>
        <input type="password"  class="form-control @error('userpass') is-invalid @enderror" name="userpass">
        <span class="text-danger">
          @error('userpass')
            {{ $message }}
          @enderror
        </span>
      </div>

      <button type="submit" class="btn btn-primary">LOGIN</button>
    </form>

      </div>
    </div>
   </div> 
</body>
</html>