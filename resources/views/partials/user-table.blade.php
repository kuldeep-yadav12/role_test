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
            @if (isset($showActions) && $showActions)
            <th width="180px">Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @php $id = 1; @endphp

        @if (isset($users) && $users->count())
        @foreach ($users as $user)
        @if (auth()->id() === $user->id)
        @continue
        @endif
        <tr>
            <td>{{ $id++ }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->gender }}</td>
            <td>{{ $user->age }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->hobbies }}</td>
            <td>{{ $user->role }}</td>

            @if (isset($showActions) && $showActions)
            <td>
                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="{{ isset($showActions) && $showActions ? 9 : 8 }}" class="text-center">No users found.
            </td>
        </tr>
        @endif
    </tbody>
</table>
