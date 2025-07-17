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
            
            @php
    $userLike = $blog->likes->where('user_id', auth()->id())->first();
    $likesCount = $blog->likes->where('type', 'like')->count();
    $dislikesCount = $blog->likes->where('type', 'dislike')->count();
@endphp

<div class="card-footer d-flex justify-content-center align-items-center">

    {{-- Like Button --}}
    <form action="{{ route('blogs.like', $blog->id) }}" method="POST" class="d-flex align-items-center gap-1">
        @csrf
        <input type="hidden" name="type" value="like">
        <button type="submit" class="btn btn-sm {{ $userLike && $userLike->type === 'like' ? 'btn-success' : 'btn-outline-success' }}">
          <i class="fa-solid fa-thumbs-up"></i>
        </button>
        <span>{{ $likesCount }}</span>
    </form>

    {{-- Dislike Button --}}
    <form action="{{ route('blogs.like', $blog->id) }}" method="POST" class="d-flex align-items-center gap-1">
        @csrf
        <input type="hidden" name="type" value="dislike">
        <button type="submit" class="btn btn-sm {{ $userLike && $userLike->type === 'dislike' ? 'btn-danger' : 'btn-outline-danger' }} ml-3">
           <i class="fa-solid fa-thumbs-down"></i>
        </button>
        <span>{{ $dislikesCount }}</span>
    </form>

</div>

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
