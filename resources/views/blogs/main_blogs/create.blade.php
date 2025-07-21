@extends("layout.app")

@section("contant")
<div class="mt-5">
    <h2 class="mb-4">Add New Blog</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('blog.main_blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter blog title">
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="5" placeholder="Enter blog content"></textarea>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Upload Image or video</label>
             {{-- <input type="file" name="images[]" multiple class="form-control" /> --}}
            <input type="file" name="media[]" multiple accept="image/*,video/*">

        </div>
        

        <button type="submit" class="btn btn-primary">Add Blog</button>
    </form>
</div>
@endsection
