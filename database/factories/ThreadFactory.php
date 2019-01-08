<?php

use Faker\Generator as Faker;

$factory->define(App\Thread::class, function (Faker $faker) {
    $title = $faker->sentence;

    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'channel_id' => function () {
            return factory('App\Channel')->create()->id;
        },
        'title' => $title,
        'body' => $faker->paragraph,
        'visits' => 0,
        'slug' => str_slug($title),
        'locked' => false
    ];
});

$factory->state(App\Thread::class, 'from_existing_channels_and_users', function ($faker) {
    $title = $faker->sentence;

    return [
        'user_id' => function () {
            return factory('App\User')->random()->id;
        },
        'channel_id' => function () {
            return factory('App\Channel')->random()->id;
        },
        'title' => $title,
        'body' => $faker->paragraph,
        'visits' => $faker->numberBetween(0, 35),
        'slug' => str_slug($title),
        'locked' => $faker->boolean(15)
    ];
});
