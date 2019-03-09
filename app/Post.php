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
            'user_id' => 'required',
            'title' => 'max:255',
            'description' => 'max:255',
            'content' => 'required'
        ]);
        
        if($request->get('user_id') == Auth::id())
        {
            $this->update($items);
        }
    }

    public static function insertPost($request)
    {
        $request->validate([
            'discussion_id' => 'required',
            'content' => 'required',
            'archived' => 'required',
            'title' => 'max:255',
            'description' => 'max:255',
        ]);

        if(!$request->get('archived')){
            Post::create([
                    'user_id' => Auth::id()
                ] + $request->only([
                'discussion_id',
                'title',
                'description',
                'content'
            ]));
        }
    }
}
