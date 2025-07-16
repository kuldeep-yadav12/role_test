<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="/">BLOGS</a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <a href="{{ route('user.profile') }}" style="text-decoration: none; color: inherit;">
                    <div class="profile-pic">
                        <div class="count-indicator">
                            <img class="img-xs rounded-circle" src="{{ isset(Auth::user()->image) ? asset('storage/' . Auth::user()->image) : asset('images/faces/face2.jpg') }}" alt="image">

                            <span class="count bg-success"></span>
                        </div>
                        <div class="profile-name">
                            <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name ?? '' }}</h5>
                            <span>{{ Auth::user()->email ?? '' }}</span>
                        </div>
                    </div>
                </a>
            </div>
        </li>


        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>

        @if (Auth::user()->role === 'admin')
        <li class="nav-item menu-items">
            <a class="nav-link" href="/">
                <span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @endif


        @if(Auth::user()->role === 'admin')
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('user.list') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-account-multiple"></i>
                </span>
                <span class="menu-title">All Users</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('blog.main_blog.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-file-document"></i>
                </span>
                <span class="menu-title">All Blogs</span>
            </a>
        </li>
        @else
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('blog.main_blog.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-file"></i>
                </span>
                <span class="menu-title">My Blogs</span>
            </a>
        </li>
        @endif
    </ul>
</nav>
