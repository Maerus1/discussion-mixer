@extends('layouts.app')

@section('content')
<div class="ml-3">
<h1>{{ $discussion->title }}</h1>
<h4>{{ $discussion->description }}</h4>
<p>By: {{ $discussion->user->name }}</p>
@if(auth()->id() == $discussion->user->id)
<a href="{{ route('discussions.edit', $discussion->id) }}"><button class="btn btn-secondary">Edit</button></a>
@endif
</div>
@foreach ($discussion->posts as $post)
    <div class="card">
        @if($post->title)
            <div class="card-header">
                {{ $post->title }}
            </div>
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $post->description }}</h5>
            <p class="card-text">{{ $post->content }}</p>
            <p class="card-text">~{{ $post->user->name }}</p>
        </div>
    </div>
@endforeach
@endsection