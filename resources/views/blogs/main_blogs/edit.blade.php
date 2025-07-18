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
                        <label>Existing Images</label>
                        <div class="row" id="image-gallery">
                            @foreach ($blog->images as $image)
                                <div class="col-md-3 mb-3 image-box" data-id="{{ $image->id }}"
                                    id="image-{{ $image->id }}">
                                    <p>Image #{{ $loop->iteration }}</p>
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                        style="width:100%; height:150px; object-fit:cover;">
                                    <a href="{{ route('blog_images.delete', $image->id) }}"
                                        class="btn btn-danger btn-sm mt-2 delete-image" data-id="{{ $image->id }}"><i
                                            class="fa fa-trash"></i></a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.delete-image').on('click', function(e) {
            e.preventDefault();

            if (!confirm('Are you sure you want to delete this image?')) return;

            let url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Failed to delete image.');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred while deleting the image.');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('image-gallery');
        new Sortable(el, {
            animation: 150,
            onEnd: function () {
                let order = [];
                document.querySelectorAll('.image-box').forEach((item, index) => {
                    order.push({
                        id: item.getAttribute('data-id'),
                        position: index + 1
                    });
                });

                // Send to server
                fetch("{{ route('blog_images.reorder') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Order updated');
                    } else {
                        alert('Failed to reorder images');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error while reordering');
                });
            }
        });
    });
</script>
@endsection
