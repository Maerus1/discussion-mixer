<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $fillable = ['user_id', 'name', 'description'];
    public static function createDiscussion($request)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'description' => 'required'
        ]);

        Discussion::create($request->all());
    }
}
