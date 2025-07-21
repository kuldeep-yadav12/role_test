@extends('layout.app')

@section('contant')
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
    <label>Existing Media (Images & Videos)</label>
    <div class="row" id="media-gallery" data-url="{{ route('blog_media.reorder', $blog->id) }}">
        @foreach ($blog->media as $media)
            <div class="col-md-3 mb-3 media-box" data-id="{{ $media->id }}" id="media-{{ $media->id }}">
                <p>Media #{{ $loop->iteration }}</p>

                @if ($media->type === 'image')
                    <img src="{{ asset('storage/' . $media->file_path) }}"
                        style="width:100%; height:150px; object-fit:cover;">
                @elseif ($media->type === 'video')
                    <video width="100%" height="150" controls style="object-fit:cover;">
                        <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif

                <a href="{{ route('blog_media.delete', $media->id) }}"
                    class="btn btn-danger btn-sm mt-2 delete-media" data-id="{{ $media->id }}">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
        @endforeach
    </div>
</div>

                    <div class="mb-3">
                         <label>Add Media (images/videos)</label>
                        <input type="file" name="media[]" multiple accept="image/*,video/*">
                        {{-- <label for="images" class="form-label">Add New Images</label>
                        <input type="file" name="images[]" class="form-control" multiple> --}}
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-success">Update Blog</button>
                    <a href="{{ route('blog.main_blog.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
    
@endsection
