<?php

use Faker\Generator as Faker;

$factory->define(App\Discussion::class, function (Faker $faker) {
    $user_id = App\User::pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($user_id),
        'name' => $faker->sentence,
        'description' => $faker->paragraph(2)
    ];
});
