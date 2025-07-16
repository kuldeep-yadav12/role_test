@if($blogs->isEmpty())
<div class="alert alert-info">No blogs available yet.</div>
@else
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
            <a href="/comment/{{ $blog->id }}"><button>Comment</button></a>
            <div class="card-body d-flex justify-content-between">
                <a href="{{ route('blog.main_blog.edit', $blog->id) }}" class="btn btn-primary">Update</a>

                <form action="{{ route('blog.main_blog.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>


        </div>
    </div>
    @endforeach
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $blogs->links('pagination::simple-bootstrap-5') }}
</div>
@endif
