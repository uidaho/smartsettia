@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
<div class="container">
    @foreach ($users as $user)
        {{ $user->name }}
    @endforeach
</div>

{{ $users->links() }}
@endsection
