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
            <!-- TODO: Implement Vue to switch between edit mode and read mode -->
            @if(auth()->id() == $post->user->id)
                <form method="POST" action="{{ route('posts.update', $post->id) }}">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" value="{{ $post->title }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" value="{{ $post->description }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" cols="30" rows="10"class="form-control" >{{ $post->content }}</textarea>
                    </div>
                    <input type="submit" value="Save" />
                </form>
            @else
                <h5 class="card-title">{{ $post->description }}</h5>
                <p class="card-text">{{ $post->content }}</p>
                <p class="card-text">~{{ $post->user->name }}</p>
            @endif
        </div>
    </div>
@endforeach
<hr/>
<h3 class="ml-3">Create New Post</h4>
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('posts.store.', $discussion->id) }}" class="mx-3">
    @csrf
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" />
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" name="description" class="form-control" />
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea name="content" cols="30" rows="10" class="form-control"></textarea>
    </div>
    <input type="submit" value="Create Post" />
</form>

@endsection