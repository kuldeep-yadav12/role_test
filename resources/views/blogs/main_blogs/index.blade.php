@extends('layout.app')

@section('contant')
<div class="m-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>All Blogs</h2>
    </div>
    @include('partials.blog_filter')

    <div id="blog-data">
        @include('blogs.main_blogs.blogs')
    </div>
</div>

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


        // FILTER FORM AJAX
        $('#blog-filter-form').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('blog.main_blog.index') }}",
                method: 'GET',
                data: formData,
                success: function(response) {
                    $('#blog-data').html(response);
                }
            });
        });

        // RESET FILTER
        $('#reset-button').on('click', function () {
            $('#blog-filter-form')[0].reset();

            $.ajax({
                url: "{{ route('blog.main_blog.index') }}",
                method: 'GET',
                success: function(response) {
                    $('#blog-data').html(response);
                }
            });
        });
    
    });
</script>
@endsection

