<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    $user_id = App\User::pluck('id')->toArray();
    $discussion_id = App\Discussion::pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($user_id),
        'discussion_id' => $faker->randomElement($discussion_id),
        'name' => $faker->sentence,
        'description' => $faker->paragraph(2),
        'content' => $faker->paragraph(4)
    ];
});
