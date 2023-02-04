<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Purchase;
use Faker\Generator as Faker;

$factory->define(Purchase::class, function (Faker $faker) {
    return [
        'code' => $faker->postcode,
        'status' => $faker->randomElement(['paid', 'pending', 'failed']),
        'payment_gateway' => $faker->randomElement(['flutter-wave', 'paystack', 'paypal']),
        'totalamount' => $faker->numberBetween(1000, 300000),
        'selar_profit' => $faker->numberBetween(5, 3000),
        'merchant_commission' => $faker->numberBetween(5, 300),
        'transaction_date' => $faker->dateTimeBetween('0 years', '+1 years ', 'UTC'),
        'currency' => $faker->randomElement(['NGN', 'KES', 'USD', 'GHS']),
        'payment_gateway_commission' => $faker->numberBetween(5, 300) * 0.1,
        'description' => $faker->paragraph,
        'price' => $faker->numberBetween(10000, 2000000),
        'created_at' => $faker->dateTimeBetween('0 years', '+ 1 years', 'UTC'),
        'updated_at' => $faker->dateTimeBetween('0 years', '+ 1 years', 'UTC'),
    ];
});
