<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class Post extends Model
{
    protected $fillable = ['user_id', 'discussion_id', 'title', 'description', 'content'];
    
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updatePost($request)
    {
        $items = $request->validate([
            'title' => 'max:255',
            'description' => 'max:255',
            'content' => 'required'
        ]);

        $this->update([
            'user_id' => Auth::id()
        ] + $items);
    }

    public static function insertPost($request, $discussion_id)
    {
        $request->validate([
            'content' => 'required',
            'title' => 'max:255',
            'description' => 'max:255',
        ]);

        $discussion = Discussion::where('id', $discussion_id)->first();
        if(!$discussion->archived){
            Post::create([
                    'user_id' => Auth::id(),
                    'discussion_id' => $discussion->id
                ] + $request->only([
                'title',
                'description',
                'content'
            ]));
        }
    }
}
