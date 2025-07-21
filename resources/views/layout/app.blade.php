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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="/js/script.js"></script>

</body>
</html>
