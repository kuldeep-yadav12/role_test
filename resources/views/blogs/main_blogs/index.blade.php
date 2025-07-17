@extends('layout.app')

@section('contant')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>All Blogs</h2>
        <a href="{{ route('blog.main_blog.create') }}" class="btn btn-success">+ Add Blog</a>
    </div>

    <div id="blog-data">
        @include('blogs.main_blogs.blogs')
    </div>
</div>


@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();

            let url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html',
                success: function (data) {
                    $('#blog-data').html(data);
                    window.history.pushState(null, '', url);
                },
                error: function () {
                    alert('Could not load the page.');
                }
            });
        });
    });
</script>
@endsection

