<?php

use Faker\Generator as Faker;

$factory->define(App\Discussion::class, function (Faker $faker) {
    return [
        'title' => $faker->realText(50),
        'description' => $faker->realText(200),
        'archived' => false
    ];
});
