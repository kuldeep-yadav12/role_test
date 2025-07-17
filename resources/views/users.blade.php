@extends('layout.app')

@section('contant')
<div class="m-5">
    <h2>All Users</h2>
    @include('partials.user-table', ['users' => $users, 'showActions' => true])
</div>
@endsection
