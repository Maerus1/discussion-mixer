@extends('layouts.app')

@section('content')
@foreach ($discussions as $discussion)
  <div class="text-center">
    <p>{{ $discussion->name }}</p>
    <p>{{ $discussion->user->name }}</p>
  </div>  
  <hr />
@endforeach
{{ $discussions->links() }}


@endsection