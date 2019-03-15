@extends('layouts.app')

@section('content')
@foreach ($discussions as $discussion)
  <div class="row justify-content-center">
    <a href="{{ route('discussions.show', $discussion->id) }}" 
      class="border text-dark
      rounded text-center col-8 pt-2">
      <h4>{{ $discussion->title }}</h4>
      <p>{{ $discussion->description }}</p>
    </a>  
  </div>
  
  <hr />
@endforeach

{{ $discussions->links() }}


@endsection