<?php

use Faker\Generator as Faker;

$factory->define(App\Indicator::class, function (Faker $faker) {
    return [
        //
        'name_en' => $faker->randomElement(['TS1','TS2']),
//        'name_ch' => $faker->randomElement(['甲状腺激素']),
        'name_ch' => '血红蛋白',
        'upper_limit' => $faker->randomFloat(null,60,100),
        'lower_limit' => $faker->randomFloat(null,60,100),
        'value' => $faker->randomFloat(null,60,100),
        'image_id' => function (){
            return factory(App\Image::class)->create()->id;
        },
//        'image_id' => 109,
        'important' => $faker->boolean

    ];
});
