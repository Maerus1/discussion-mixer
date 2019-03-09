<?php

namespace App\Http\Controllers;

use App\Post;
use App\Discussion;
use Illuminate\Http\Request;

class PostController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $discussion_id)
    {
        Post::insertPost($request, $discussion_id);
        return view('discussions.show', [
           'discussion' => Discussion::where('id', $discussion_id)
                                 ->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->updatePost($request);
        return view('discussions.show', [
            'discussion' => Discussion::where('id', $post->discussion_id)
                                 ->first()
         ]);
    }
}
