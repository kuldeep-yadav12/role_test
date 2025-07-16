@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2>{{ $blog->title }}</h2>
    <p>{{ $blog->content }}</p>

    @if($blog->image)
        <img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" style="width: 100%; max-width: 600px;">
    @endif
</div>
@endsection
