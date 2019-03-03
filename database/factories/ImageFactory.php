<?php

use Faker\Generator as Faker;

$factory->define(App\Image::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
//        'type' => $faker->randomElement(['血常规','甲功能','肝功能']),
        'type' => '肝功能',
        'created_at' => $faker->dateTime,
        'user_id' => 1,
    ];
});
