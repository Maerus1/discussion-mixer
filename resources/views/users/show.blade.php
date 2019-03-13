@extends('layouts.app')

@section('content')
<div class="container">
<h1>View Profile</h1>

<h4>Username</h4>
<p>{{ $user->name }}</p>

<h4>Email</h4>
<p>{{ $user->email }}</p>

<a href="{{ route('users.edit', Auth::id()) }}">Edit Profile</a>
</div>


@endsection