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
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>Hobbies</th>
                    <th>Role</th>
                    <th width="180px">Actions</th>
                    <th><input type="checkbox" id="select-all-users"></th>
                </tr>
            </thead>
            <tbody id="user-table">
                @include('partials.user-table', ['users' => $users, 'showActions' => true])
            </tbody>
        </table>
    </div>

    {{-- Trash Users Tab --}}
    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <h2>Trash Users</h2>

        @if ($trashedUsers->count())
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
                <tbody>
                    @foreach ($trashedUsers as $user)
                        <tr>
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
        @else
            <div class="alert alert-info">No trashed users found.</div>
        @endif
    </div>
</div>

<button type="button" id="bulk-soft-delete" class="btn btn-danger mb-2">
    Delete Selected
</button>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#select-all-users').on('change', function() {
        $('.user-checkbox').prop('checked', $(this).is(':checked'));
    });

    $('#bulk-soft-delete').on('click', function() {
        let selected = [];
        $('.user-checkbox:checked').each(function() {
            selected.push($(this).val());
        });

        if (selected.length === 0) {
            alert("Please select at least one user.");
            return;
        }

        if (!confirm("Are you sure you want to soft delete selected users?")) {
            return;
        }

        $.ajax({
            url: "{{ route('users.bulkSoftDelete') }}",
            method: 'POST',
            data: {
                user_ids: selected,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(err) {
                console.log(err);
                alert('Something went wrong.');
            }
        });
    });
</script>
