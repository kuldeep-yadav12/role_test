@extends("layout.app")

@section("contant")
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>All Blogs</h2>
        <a href="{{ route('blog.main_blog.create') }}" class="btn btn-success">+ Add Blog</a>
    </div>

    @if($blogs->isEmpty())
        <div class="alert alert-info">No blogs available yet.</div>
    @endif

    <div class="row">
        @foreach ($blogs as $blog)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top" style="object-fit: cover; height: 200px;" alt="Blog Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <p class="card-text">{{ Str::limit($blog->content, 150) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
