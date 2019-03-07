<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $fillable = ['user_id', 'name', 'description'];

    public static function getActiveDiscussions()
    {
        return Discussion::where('archived', false)
            ->get();
    }

    public static function getArchivedDiscussions()
    {
        return Discussion::where('archived', true)
            ->get();
    }

    public static function createDiscussion($request)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'description' => 'required'
        ]);

        //update all discussions for a user to set 'archived' to true
        Discussion::where('user_id', $request->user_id)
            ->update(['archived' => true]);
        
        //create a new discussion with 'archived' set to false
        Discussion::create($request->except([
            '_token', 
            '_method'
        ]));
    }

    public static function updateDiscussion($request)
    {
        $request->validate([
            'user_id' => 'required',
            'id' => 'required',
            'name' => 'required',
            'description' => 'required'
        ]);
        
        //only update a discussion that belongs to the
        //user requesting the change
        Discussion::where('id', $request->id)
            ->where('user_id', $request->user_id)
            ->update($request->except([
            '_token',
            '_method',
            'user_id',
            'id'
        ]));
    }
}
