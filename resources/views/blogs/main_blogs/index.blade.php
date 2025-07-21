@extends('layout.app')

@section('contant')
    <div class="m-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Blogs</h2>
        </div>
        @include('partials.blog_filter')
        @include('partials.blog_tabs', [
            'blogs' => $blogs,
            'trashedBlogs' => $trashedBlogs,
            'activeTab' => $activeTab,
        ])

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {

    // Handle Tab Switching (just updates hidden input)
    $('.nav-link').on('click', function () {
        let tab = $(this).attr('id') === 'trash-blogs-tab' ? 'trash' : 'all';
        $('#active-tab-input').val(tab);
    });

    // FILTER AJAX
    $('#blog-filter-form').on('submit', function (e) {
    e.preventDefault(); // Prevent page reload

    let formData = $(this).serialize();
    let activeTab = $('#active-tab-input').val();

    $.ajax({
        url: "{{ route('blog.main_blog.index') }}",
        method: 'GET',
        data: formData,
        success: function (response) {
            if (activeTab === 'trash') {
                $('#trash-blogs').html(response);
            } else {
                $('#all-blogs').html(response);
            }
        },
        error: function () {
            alert('Something went wrong!');
        }
    });
});


    // PAGINATION AJAX
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();

        let url = $(this).attr('href');
        let tab = url.includes('trash_page') ? 'trash' : 'all';
        $('#active-tab-input').val(tab);

        $.ajax({
            url: url + '&tab=' + tab,
            type: 'GET',
            success: function (response) {
                if (tab === 'trash') {
                    $('#trash-blogs').html(response);
                    activateBootstrapTab('#trash-blogs-tab');
                } else {
                    $('#all-blogs').html(response);
                    activateBootstrapTab('#all-blogs-tab');
                }
                window.history.pushState(null, '', url + '&tab=' + tab);
            },
            error: function () {
                alert('Pagination error.');
            }
        });
    });

    // RESET BUTTON
    $('#reset-button').on('click', function () {
        $('#blog-filter-form')[0].reset();
        let tab = $('#active-tab-input').val();

        $.ajax({
            url: "{{ route('blog.main_blog.index') }}",
            method: 'GET',
            data: { tab: tab },
            success: function (response) {
                if (tab === 'trash') {
                    $('#trash-blogs').html(response);
                    activateBootstrapTab('#trash-blogs-tab');
                } else {
                    $('#all-blogs').html(response);
                    activateBootstrapTab('#all-blogs-tab');
                }
                window.history.pushState(null, '', "{{ route('blog.main_blog.index') }}?tab=" + tab);
            },
            error: function () {
                alert('Reset error.');
            }
        });
    });

    // 🔁 Re-activate Bootstrap Tab after AJAX
    function activateBootstrapTab(tabSelector) {
        let tabTrigger = new bootstrap.Tab(document.querySelector(tabSelector));
        tabTrigger.show();
    }
});

    </script>
@endsection
