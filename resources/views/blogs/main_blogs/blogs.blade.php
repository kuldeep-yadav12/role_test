@if ($blogs->isEmpty())
<div class="alert alert-info">
    {{ $isTrash ?? false ? 'No trashed blogs available.' : 'No blogs available yet.' }}
</div>
@else
<div class="row">
    @foreach ($blogs as $blog)
    <div class="col-md-4 mb-4">
        <div class="card h-100">

            {{-- Swiper or default image --}}
            @if ($blog->images->count())
            <div class="swiper blog-swiper-{{ $blog->id }}">
                <div class="swiper-wrapper">
                    @foreach ($blog->images as $image)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" style="object-fit: cover; height: 200px;" alt="Blog Image">
                    </div>
                    @endforeach
                </div>
                @if ($blog->images->count() > 1)
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                @endif
            </div>
            @else
            <img src="{{ asset('images/no-image.avif') }}" class="card-img-top" style="object-fit: cover; height: 200px;" alt="No Image">
            @endif

            <div class="card-body">
                {{-- User Info --}}
                @if ($blog->user)
                <div class="d-flex align-items-center mb-3">
                    @if ($blog->user->image)
                    <img src="{{ asset('storage/' . $blog->user->image) }}" alt="User Image" class="rounded-circle mr-3" style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                    <img src="{{ asset('images/no-image.avif') }}" class="card-img-top rounded-circle mr-3" style="width: 40px; height: 40px; object-fit: cover; " alt="No Image">
                    @endif

                    <div>
                        <div><strong>{{ $blog->user->name }}</strong></div>
                        <small class="text-muted">{{ $blog->user->email }}</small>
                    </div>
                </div>
                @else
                <div class="mb-3 text-muted">Unknown Author</div>
                @endif

                <h5 class="card-title">{{ $blog->title }}</h5>
                <p class="card-text">{{ Str::limit($blog->content, 150) }}</p>

                <!-- Comment Toggle -->
                <button type="button" class="btn btn-warning toggle-comments" data-id="{{ $blog->id }}">
                    <i class="fa-solid fa-comment"></i> {{ $blog->comments->count() }}
                </button>

                <div class="comment-section mt-2" id="comments-{{ $blog->id }}" style="display: none;">
                    @foreach ($blog->comments as $comment)
                    <div class="mb-2 border-bottom pb-2 comment-row" id="comment-{{ $comment->id }}">
                        <p><strong>{{ $comment->user->name ?? 'Unknown User' }}:</strong>
                            {{ $comment->body }}</p>

                        <div class="d-flex align-items-center gap-2">
                            @if (auth()->user()->role === 'admin' || auth()->id() === $comment->user_id)
                            <button class="btn btn-sm btn-outline-success like-comment-btn" data-id="{{ $comment->id }}">
                                <i class="fa-solid fa-thumbs-up"></i>
                                <span id="like-count-{{ $comment->id }}">{{ $comment->likes()->count() }}</span>

                            </button>


                            <button class="btn btn-sm btn-outline-danger delete-comment-btn mx-2" data-id="{{ $comment->id }}">
                                <i class="fa fa-trash"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-primary edit-comment-btn" data-id="{{ $comment->id }}">
                                <i class="fa fa-pen"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    {{-- comment form blog --}}
                    <form id="comment-form" action="{{ route('comments.store') }}" method="POST" onsubmit="disableButton()">
                        @csrf
                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                        <textarea name="body" class="form-control mb-2" required></textarea>
                        <button type="submit" id="comment-btn" class="btn btn-sm btn-primary">Comment</button>
                    </form>


                </div>
            </div>


            @php
            $userLike = $blog->likes->where('user_id', auth()->id())->first();
            $likesCount = $blog->likes->where('type', 'like')->count();
            $dislikesCount = $blog->likes->where('type', 'dislike')->count();
            @endphp

            <!-- Likes, Edit, Delete -->
            <div class="card-footer d-flex justify-content-between align-items-center">
                <button class="btn btn-success like-btn" data-id="{{ $blog->id }}" data-type="like">
                    <i class="fa-solid fa-thumbs-up"></i> <span class="like-count">{{ $likesCount }}</span>
                </button>
                <button class="btn btn-danger dislike-btn" data-id="{{ $blog->id }}" data-type="dislike">
                    <i class="fa-solid fa-thumbs-down"></i> <span class="dislike-count">{{ $dislikesCount }}</span>
                </button>

                @if (!($isTrash ?? false) && (Auth::user()->role === 'admin' || $blog->user_id === Auth::user()->id))
                <a href="{{ route('blog.main_blog.edit', $blog->id) }}" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></a>
                <form action="{{ route('blog.main_blog.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                </form>
                @endif
                @if ($isTrash ?? false)
                <form action="{{ route('blog.restore', $blog->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-rotate-left"></i> Restore
                    </button>
                </form>

                <form action="{{ route('blog.forceDelete', $blog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i> Delete Permanently
                    </button>
                </form>
                @endif

            </div>

        </div>
    </div>
    @endforeach
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const likeButtons = document.querySelectorAll('.like-comment-btn');

        likeButtons.forEach(button => {
            button.addEventListener('click', function () {
                const commentId = this.getAttribute('data-id');

                fetch(`/comments/${commentId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.likes !== undefined) {
                        document.getElementById(`like-count-${commentId}`).innerText = data.likes;
                    }
                })
                .catch(err => {
                    console.error("Like error:", err);
                });
            });
        });
    });
</script>

<div class="mt-4 d-flex justify-content-center">
    {{ $blogs->appends(['tab' => isset($isTrash) && $isTrash ? 'trash' : 'all'])->links('pagination::simple-bootstrap-5') }}
</div>
@endif
