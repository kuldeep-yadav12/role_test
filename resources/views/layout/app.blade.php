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
    <title>First Project</title>
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
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</html>
