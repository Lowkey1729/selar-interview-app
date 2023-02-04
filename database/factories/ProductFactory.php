<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'code' => $faker->postcode(),
        'currency' => $faker->randomElement(['NGN', 'KES', 'USD', 'GHS']),
        'price' => $faker->numberBetween(10000, 2000000),
        'description' => $faker->paragraph,
        'created_at' => $faker->dateTimeBetween('0 years', '+ 1 years', 'UTC'),
        'updated_at' => $faker->dateTimeBetween('0 years', '+ 1 years', 'UTC'),
    ];
});


