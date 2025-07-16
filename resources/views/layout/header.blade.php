     <nav class="navbar p-0 fixed-top d-flex flex-row">
         <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
             <a class="navbar-brand brand-logo-mini" href="{{ URL('/') }}"><img src="/images/logo-mini.svg" alt="logo" /></a>
         </div>

         <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
             <ul class="navbar-nav w-100">
                 <li class="nav-item w-100">
                     <h3 class="wel_head">
                         WELCOME @if(Auth::user()->role === 'system_user') User @else Admin @endif <strong>{{(Auth::user()->name ?? '') }}</strong>
                     </h3>
                 </li>
             </ul>
             <ul class="navbar-nav navbar-nav-right">


                 <li class="nav-item dropdown">
                     <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                         <div class="navbar-profile">
                             <img class="img-xs rounded-circle" src="{{ isset(Auth::user()->image) ? asset('storage/' . Auth::user()->image) : asset('images/faces/face2.jpg') }}" alt="image">
                             <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ Auth::user()->name ?? ''}}</p>
                             <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                         </div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                         <h6 class="p-3 mb-0">Profile</h6>

                         <a class="dropdown-item" href="" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout</a>
                         <form id="logout-form" action="{{ route('logout') }}" method="POST">
                             @csrf
                         </form>
                     </div>
                     </a>

                 </li>
             </ul>

             <ul class="navbar-nav ms-auto">
                 @auth
                 <li class="nav-item">
                     <a class="nav-link" href="#" onclick="event.preventDefault();
                         document.getElementById('logout-form-inline').submit();">Logout</a>
                     <form id="logout-form-inline" action="{{ route('logout') }}" method="POST" class="d-none">
                         @csrf
                     </form>

                 </li>
                 @endauth

                 @guest
                 <li class="nav-item">
                     <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('user.store') }}">Register</a>

                 </li>

                 {{-- <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                             aria-expanded="false">
                             {{ Auth::user()->name }}
                 </a>

                 </li> --}}
                 @endguest
             </ul>
             {{-- <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                 data-toggle="offcanvas">
                 <span class="mdi mdi-format-line-spacing"></span>
             </button> --}}
         </div>
     </nav>
