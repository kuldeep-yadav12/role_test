@extends('layout.app')

@section('contant')
<div class="container mt-5">
    <div class="card shadow-lg p-4 mx-auto" style="max-width: 600px;">
        <div class="text-center">
            <!-- Profile Image -->
            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/faces/default.jpg') }}" class="rounded-circle mb-3  border-primary" width="120" height="120" style="object-fit: cover;">

            <!-- Image Upload Form -->
            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="image" class="form-label">Change Profile Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary">Update Profile Image</button>
            </form>

            <!-- User Info -->
            <h4 class="fw-bold mt-3">{{ $user->name }}</h4>
            <p class="text-muted">{{ $user->email }}</p>
        </div>

        <hr>

        <!-- Additional Details -->
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Role:</strong> {{ ucfirst($user->role) }}</li>
            <li class="list-group-item"><strong>Gender:</strong> {{ $user->gender }}</li>
            <li class="list-group-item"><strong>Age:</strong> {{ $user->age }}</li>
            <li class="list-group-item"><strong>Phone:</strong> {{ $user->phone }}</li>
            <li class="list-group-item"><strong>Hobbies:</strong> {{ $user->hobbies }}</li>
        </ul>

        <div class="text-center mt-4">
            <a href="{{ route('blog.main_blog.index') }}" class="btn btn-dark">Back to Blogs</a>
        </div>
    </div>
</div>
@endsection
