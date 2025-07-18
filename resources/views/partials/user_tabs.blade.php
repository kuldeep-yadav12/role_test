<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button"
            role="tab" aria-controls="pills-home" aria-selected="true">All Users</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
            type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Trash Users</button>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    {{-- All Users Tab --}}
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <h2>All Users</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @include('partials.user-filter', ['users' => $users, 'showActions' => true])

        <table class="table table-bordered table-striped mt-4">
            <thead class="table-dark">
                <tr>
                    <th><input type="checkbox" class="select-all-checkbox" data-target=".user-checkbox"></th>
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
        <button class="btn btn-danger bulk-action-btn" data-target=".user-checkbox"
            data-url="{{ route('users.bulkSoftDelete') }}"
            data-confirm="Are you sure you want to delete selected users?">
            Delete Selected
        </button>
    </div>

    {{-- Trash Users Tab --}}
    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <h2>Trash Users</h2>

        @if ($trashedUsers->count())
            <table class="table table-bordered table-striped mt-4">
                <thead class="table-dark">
                    <tr>
                        <th><input type="checkbox" class="select-all-checkbox" data-target=".trashed-user-checkbox">
                        </th>
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
                <tbody>
                    @foreach ($trashedUsers as $user)
                        <tr>
                            <td><input type="checkbox" class="trashed-user-checkbox" name="user_ids[]" value="{{ $user->id }}"></td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->gender }}</td>
                            <td>{{ $user->age }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->hobbies }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <a href="{{ route('user.restore', $user->id) }}"
                                    class="btn btn-success btn-sm">Restore</a>

                                <form action="{{ route('user.forceDelete', $user->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Are you sure to permanently delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button class="btn btn-success bulk-action-btn" data-target=".trashed-user-checkbox"
                data-url="{{ route('users.bulkRestore') }}" data-confirm="Restore selected users?">
                Restore Selected
            </button>
        @else
            <div class="alert alert-info">No trashed users found.</div>
        @endif
    </div>
</div>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Handle select all
    $('.select-all-checkbox').on('change', function() {
        const targetClass = $(this).data('target');
        $(targetClass).prop('checked', $(this).is(':checked'));
    });

    // Handle bulk action
    $('.bulk-action-btn').on('click', function() {
        const checkboxes = $(this).data('target');
        const selected = [];
        $(checkboxes + ':checked').each(function() {
            selected.push($(this).val());
        });

        if (selected.length === 0) {
            alert("Please select at least one user.");
            return;
        }

        const confirmMessage = $(this).data('confirm');
        if (!confirm(confirmMessage)) return;

        $.ajax({
            url: $(this).data('url'),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_ids: selected,
            },
            success: function() {
                location.reload();
            },
            error: function(err) {
                console.log(err);
                alert('Something went wrong.');
            }
        });
    });
</script>
