<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    \App\User::query()->truncate();
    \App\Purchase::query()->truncate();
    \App\Product::query()->truncate();

    return [
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'fullname' => sprintf("%s %s", $faker->firstName, $faker->lastName),
        'created_at' => now(),
        'updated_at' => now()
    ];
});
