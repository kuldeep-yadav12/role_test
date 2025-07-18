@if ($blogs->isEmpty())
    <div class="alert alert-info">No blogs available yet.</div>
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
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top"
                        style="object-fit: cover; height: 200px;" alt="Blog Image">
                </div>
            @endforeach
        </div>

        @if ($blog->images->count() > 1)
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        @endif
    </div>
@else
    <img src="{{ asset('images/no-image.png') }}" class="card-img-top"
        style="object-fit: cover; height: 200px;" alt="No Image">
@endif


                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <p class="card-text">{{ Str::limit($blog->content, 150) }}</p>

                        <!-- Comment Toggle -->
                        <button type="button" class="btn btn-warning toggle-comments" data-id="{{ $blog->id }}">
                            <i class="fa-solid fa-comment"></i> {{ $blog->comments->count() }}
                        </button>

                        <div class="comment-section mt-2" id="comments-{{ $blog->id }}" style="display: none;">
                            @foreach ($blog->comments as $comment)
                                <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->body }}</p>
                            @endforeach

                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                <textarea name="body" class="form-control mb-2" required></textarea>
                                <button type="submit" class="btn btn-sm btn-primary">Comment</button>
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
                            <i class="fa-solid fa-thumbs-up"></i> <span
                                id="like-count-{{ $blog->id }}">{{ $likesCount }}</span>
                        </button>
                        <button class="btn btn-danger dislike-btn" data-id="{{ $blog->id }}" data-type="dislike">
                            <i class="fa-solid fa-thumbs-down"></i> <span
                                id="dislike-count-{{ $blog->id }}">{{ $dislikesCount }}</span>
                        </button>
                        <a href="{{ route('blog.main_blog.edit', $blog->id) }}" class="btn btn-primary"><i
                                class="fa-solid fa-pencil"></i></a>
                        <form action="{{ route('blog.main_blog.destroy', $blog->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-comments').forEach(button => {
                button.addEventListener('click', function() {
                    const blogId = this.getAttribute('data-id');
                    const commentBox = document.getElementById('comments-' + blogId);
                    commentBox.style.display = commentBox.style.display === 'none' ? 'block' :
                        'none';
                });
            });
        });
    </script>

    <div class="mt-4 d-flex justify-content-center">
        {{ $blogs->links('pagination::simple-bootstrap-5') }}
    </div>
@endif
