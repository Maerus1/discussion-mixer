@extends('layouts.app')

@section('content')
@if($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
<form class="col-6" method="POST" action="{{ route('discussions.update', $discussion->id) }}">
  @method('PUT')  
  @csrf
    <div class="form-group">
      <label for="title">Discussion Title</label>
      <input type="text" class="form-control" value="{{ $discussion->title }}" name="title" required/>
    </div>
    <div class="form-group">
      <label for="description">Discussion Description</label>
      <input type="text" class="form-control" value="{{ $discussion->description }}" name="description" />
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
@endsection