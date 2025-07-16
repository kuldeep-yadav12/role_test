<form method="POST" action="{{ route('blog.main_blog.update', $blog->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Title -->
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" value="{{ $blog->title }}" class="form-control" required>
    </div>

    <!-- Content -->
    <div class="form-group mt-2">
        <label>Content</label>
        <textarea name="content" rows="5" class="form-control">{{ $blog->content }}</textarea>
    </div>

    <!-- Image -->
    <div class="form-group mt-2">
        <label>Image</label>
        <input type="file" name="image" class="form-control">
        @if($blog->image)
            <img src="{{ asset('storage/' . $blog->image) }}" width="100" class="mt-2">
        @endif
    </div>

    <button type="submit" class="btn btn-success mt-3">Update Blog</button>
</form>
