@if ($blogs->isEmpty())
<div class="alert alert-info">No blogs available yet.</div>
@else
<div class="row">
    @foreach ($blogs as $blog)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            @if ($blog->image)
            <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top" style="object-fit: cover; height: 200px;" alt="Blog Image">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $blog->title }}</h5>
                <p class="card-text">{{ Str::limit($blog->content, 150) }}</p>
            </div>


            <!-- Comment Icon with Count -->
            <button type="button" class="btn btn-warning toggle-comments" data-id="{{ $blog->id }}">
                <i class="fa-solid fa-comment"></i> {{ $blog->comments->count() }}
            </button>

            <!-- Hidden Comment Section -->
            <div class="comment-section mt-2" id="comments-{{ $blog->id }}" style="display: none;">
                <div class="comments-list">
                    @foreach ($blog->comments as $comment)
                    <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->body }}</p>
                    @endforeach
                </div>

                <!-- Add Comment Form -->
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                    <textarea name="body" rows="2" class="form-control mb-2" placeholder="Add a comment..." required></textarea>
                    <button type="submit" class="btn btn-sm btn-primary">Comment</button>
                </form>
            </div>




            @php
            $userLike = $blog->likes->where('user_id', auth()->id())->first();
            $likesCount = $blog->likes->where('type', 'like')->count();
            $dislikesCount = $blog->likes->where('type', 'dislike')->count();
            @endphp

            <div class="card-footer d-flex justify-content-between align-items-center">



                {{-- <a class="btn btn-warning" href="/comment/{{ $blog->id }}"><i class="fa-solid fa-comment"></i></a> --}}

                <button class="btn btn-success like-btn" data-id="{{ $blog->id }}" data-type="like">
                    <i class="fa-solid fa-thumbs-up"></i> <span id="like-count-{{ $blog->id }}">{{ $blog->likes()->where('type', 'like')->count() }}</span>
                </button>

                <button class="btn btn-danger dislike-btn" data-id="{{ $blog->id }}" data-type="dislike">
                    <i class="fa-solid fa-thumbs-down"></i> <span id="dislike-count-{{ $blog->id }}">{{ $blog->likes()->where('type', 'dislike')->count() }}</span>
                </button>

                <a href="{{ route('blog.main_blog.edit', $blog->id) }}" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></a>

                <form action="{{ route('blog.main_blog.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                </form>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>

                </script>

            </div>



        </div>
    </div>
    @endforeach
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-comments').forEach(button => {
            button.addEventListener('click', function () {
                const blogId = this.getAttribute('data-id');
                const commentBox = document.getElementById('comments-' + blogId);
                commentBox.style.display = commentBox.style.display === 'none' ? 'block' : 'none';
            });
        });
    });
</script>

<div class="mt-4 d-flex justify-content-center">
    {{ $blogs->links('pagination::simple-bootstrap-5') }}
</div>
@endif
