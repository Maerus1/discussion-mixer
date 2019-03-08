@extends('layouts.app')

@section('content')
@foreach ($discussion->posts as $post)
    <p>{{ $post->content }}</p>
@endforeach
@endsection