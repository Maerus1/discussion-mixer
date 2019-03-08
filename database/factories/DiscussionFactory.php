<?php

use Faker\Generator as Faker;

$factory->define(App\Discussion::class, function (Faker $faker) {
    return [
        'name' => $faker->realText(50),
        'description' => $faker->realText(200),
        'archived' => false
    ];
});
