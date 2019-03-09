<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Discussion extends Model
{
    protected $fillable = ['user_id', 'title', 'description'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createDiscussion($request)
    {
        $items = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => 'max:255'
        ]);

        //update all discussions for a user to set 'archived' to true
        Discussion::where('user_id', Auth::id())
            ->update(['archived' => true]);
        
        //create a new discussion with 'archived' set to false
        Discussion::create([
            'user_id' => Auth::id()
        ] + $items);
    }

    public function updateDiscussion($request)
    {
        $items = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => 'max:255'
        ]);

        if($this->user_id == Auth::id())
        {
            $this->update($items);
        }
    }
}
