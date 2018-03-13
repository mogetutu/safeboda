<?php

use Faker\Generator as Faker;

$factory->define(Safeboda\Promocode::class, function (Faker $faker) {
    return [
        'code' => $faker->ean13,
        'expires_at' => $faker->dateTimeThisMonth,
        'active' => $faker->boolean(60),
        'longitude' => $faker->longitude,
        'latitude' => $faker->latitude,
        'discount' => $faker->numberBetween(200, 1000),
    ];
});
