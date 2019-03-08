@extends('layouts.app')

@section('content')
@foreach ($discussions as $discussion)
  <a href="{{ route('discussions.show', $discussion->id) }}" class="text-center">
    <h4>{{ $discussion->name }}</h4>
    <p>{{ $discussion->description }}</p>
  </a>  
  <hr />
@endforeach
{{ $discussions->links() }}


@endsection