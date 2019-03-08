<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Discussion::all()->each(function($discussion){
            $discussion->posts()->saveMany(factory(App\Post::class, 2)->make([
                'user_id' => $discussion->user->id
            ]));
        });
    }
}
