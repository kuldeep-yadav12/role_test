
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
     
</head>
<body>
   <div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-4 p-5 bg-info-subtle mt-5 rounded-4">
@yield('heading')

 <div class="div">
    <div class="row">
        <div class="col">
            @if (session('status'))
           <div class="div alert alert-success">
                    {{ session('status') }}
                </div>
                
            @endif
        </div>
    </div>
 </div>
 <div class="row">
            <div class="col-9">
       @yield('content')

     
    </div>
   </div> 
</body>
</html>