@extends("layout.app")

@section("contant")
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4>Edit Blog</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('blog.main_blog.update', $blog->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" value="{{ $blog->title }}" class="form-control" required>
                </div>

                <!-- Content -->
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" rows="5" class="form-control" required>{{ $blog->content }}</textarea>
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                    @if($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" width="120" class="mt-2 rounded border">
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-success">Update Blog</button>
                <a href="{{ route('blog.main_blog.index') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
