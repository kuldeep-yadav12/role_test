<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>First Project</title>
    <style>
        .swiper {
            width: 100%;
            height: 200px;
            object-fit: cover;
            object-position: top;
            background: :transparent;
            overflow: hidden;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: red;
            width: 24px;
            height: 24px;
        }

    </style>
</head>

<body>
    <div class="container-scroller">
        @include('layout.sidebar')
        <div class="container-fluid page-body-wrapper">
            @include('layout.header')

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('contant')
                </div>
            </div>
        </div>

    </div>
    @include('layout.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="/js/script.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".swiper").forEach((swiperEl) => {
                new Swiper(swiperEl, {
                    loop: true
                    , navigation: {
                        nextEl: swiperEl.querySelector(".swiper-button-next")
                        , prevEl: swiperEl.querySelector(".swiper-button-prev")
                    , }
                , });
            });
        });

        $(document).ready(function() {
            $(document).off('click', '.like-btn, .dislike-btn').on('click', '.like-btn, .dislike-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const blogId = $(this).data('id');
                const type = $(this).data('type');

                $.ajax({
                url: '{{ route('like.toggle') }}'
                    , method: 'POST'
                    , data: {
                        _token: "{{ csrf_token() }}"
                        , blog_id: blogId
                        , type: type
                    }
                    , success: function(data) {
                        $('#like-count-' + blogId).text(data.likes);
                        $('#dislike-count-' + blogId).text(data.dislikes);
                    }
                    , error: function(xhr) {
                        alert('You must be logged in or something went wrong.');
                        console.log(xhr.responseText);
                    }
                });
            });
        });

    </script>

</body>
</html>
