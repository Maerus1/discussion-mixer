<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class Post extends Model
{
    protected $fillable = ['user_id', 'discussion_id', 'name', 'description', 'content'];
    
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
        $request->validate([
            'content' => 'required'
        ]);
        
        $this->update($request->only([
            'name',
            'description',
            'content'
        ]));
    }

    public static function insertPost($request)
    {
        $request->validate([
            'discussion_id' => 'required',
            'content' => 'required',
            'archived' => 'required'
        ]);

        if(!$request->get('archived')){
            Post::create([
                    'user_id' => Auth::id()
                ] + $request->only([
                'discussion_id',
                'name',
                'description',
                'content'
            ]));
        }
    }
}
