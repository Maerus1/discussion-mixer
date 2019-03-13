@extends('layouts.app')

@section('content')
<div class="container">
<form class="col-6" method="POST" action="{{ route('users.update', Auth::id()) }}">
  @method('PUT')
  @csrf
  <div class="form-group">
    <label for="name">Username</label>
    <input type="text" class="form-control" name="name" required/>
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" name="email" required/>
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
</form>
</div>
@endsection