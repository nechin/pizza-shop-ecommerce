<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Discount;
use Faker\Generator as Faker;

$factory->define(Discount::class, function (Faker $faker) {
    return [
        'value' => $faker->numberBetween(1, 10),
        'type' => $faker->randomElement([0, 1]),
        'code' => $faker->shuffleString('ABCD1234')
    ];
});
