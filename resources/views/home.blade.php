@extends("layout.app")
@section("contant")

<!-- partial -->
<div class="row">
    @if(Auth::user()->role === 'admin')
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $userCount }}</h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">All Users</h6>
                </div>
            </div>
        </div>
    @endif

    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{ $postCount }}</h3>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-success">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">
                    {{ Auth::user()->role === 'admin' ? 'All Posts' : 'Your Posts' }}
                </h6>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->role === 'admin')
    <div class="container mt-5">
        <h2>All Users</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @include('partials.user-table', ['users' => $users, 'showActions' => true])
    </div>
@endif

@endsection
