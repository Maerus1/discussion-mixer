<?php

use Illuminate\Database\Seeder;

class DiscussionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::all()->each(function($user){
            factory(App\Discussion::class)->create([
                'user_id' => $user->id
            ]);
        });
    }
}
