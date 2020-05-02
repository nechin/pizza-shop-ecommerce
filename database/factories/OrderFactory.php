<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'total' => $faker->randomNumber(),
        'discount_total' => $faker->randomNumber(),
        'state' => $faker->randomElement([0, 1, 2]),
        'address' => $faker->address
    ];
});
