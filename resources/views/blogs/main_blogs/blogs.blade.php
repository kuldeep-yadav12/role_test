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

    <button class="btn btn-success like-btn"
            data-id="{{ $blog->id }}"
            data-type="like">
             <i class="fa-solid fa-thumbs-up"></i> <span id="like-count-{{ $blog->id }}">{{ $blog->likes()->where('type', 'like')->count() }}</span>
        </button>

        <button class="btn btn-danger dislike-btn ml-3"
            data-id="{{ $blog->id }}"
            data-type="dislike">
              <i class="fa-solid fa-thumbs-down"></i>  <span id="dislike-count-{{ $blog->id }}">{{ $blog->likes()->where('type', 'dislike')->count() }}</span>
        </button>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('.like-btn, .dislike-btn').click(function () {
        let blogId = $(this).data('id');
        let type = $(this).data('type');

        $.ajax({
            url: '{{ route("like.toggle") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                blog_id: blogId,
                type: type
            },
            success: function (data) {
                $('#like-count-' + blogId).text(data.likes);
                $('#dislike-count-' + blogId).text(data.dislikes);
            },
            error: function (xhr) {
                alert('You must be logged in or something went wrong.');
                console.log(xhr.responseText);
            }
        });
    });
});
</script>

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





