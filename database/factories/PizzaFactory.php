<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Pizza;
use Faker\Generator as Faker;

$factory->define(Pizza::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'image' => $faker->imageUrl(),
        'size' => 30,
        'weight' => 350,
        'price' => $faker->randomFloat(null, 5, 30),
    ];
});
