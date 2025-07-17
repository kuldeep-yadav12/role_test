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

     @include('partials.user-filter', ['users' => $users,'showActions' => true])
      <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>#ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Phone</th>
                <th>Hobbies</th>
                <th>Role</th>
                <th width="180px">Actions</th>
                
            </tr>
        </thead>
        <tbody id="user-table">
            @include('partials.user-table', ['users' => $users, 'showActions' => true])
        </tbody>
    </table>
    </div>
@endif

{{-- ======user filter===== --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    console.log("Filter JS loaded!");

    $('#user-filter-form').on('submit', function(e){
        e.preventDefault();

        $.ajax({
            url: "{{ route('user.list') }}",
            method: "GET",
            data: $(this).serialize(),
            success: function(response){
                $('#user-table').html(response.html);
            },
            error: function(err){
                alert('Something went wrong');
                console.log(err);
            }
        });

        // Reset button
    $('#reset-button').on('click', function () {
        $('#user-filter-form')[0].reset();
        $.ajax({
            url: "{{ route('user.list') }}",
            type: "GET",
            success: function (response) {
                $('#user-table').html(response.html);
            }
        });
    });

    });
</script>

@endsection


