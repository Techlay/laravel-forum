<?php

use Faker\Generator as Faker;

$factory->define(App\Channel::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
    ];
});
