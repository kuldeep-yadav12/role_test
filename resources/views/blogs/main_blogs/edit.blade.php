@extends("layout.app")

@section("contant")
<div class="mt-5">
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

                
                <div class="mb-3">
            <label>Existing Images</label>
            <div class="row">
                @foreach ($blog->images as $image)
                    <div class="col-md-3 mb-3">
                        <img src="{{ asset('storage/' . $image->image_path) }}" style="width:100%; height:150px; object-fit:cover;">
                        <div class="form-check mt-2">
                            <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="form-check-input">
                            <label class="form-check-label p-0">Remove</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Add New Images</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-success">Update Blog</button>
                <a href="{{ route('blog.main_blog.index') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
