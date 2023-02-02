<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Currency;
use Faker\Generator as Faker;

$factory->define(Currency::class, function (Faker $faker) {

    $code = $faker->unique()->randomElement(['NGN', 'KES', 'USD', 'GHS']);
    return [
        'code' => $code,
        'name' => getName()[$code]
    ];
});

function getName(): array
{
    return [
        'NGN' => 'Naira(NGN)',
        'GHS' => 'CEDIS(GHS)',
        'KES' => 'Kenya Shillings(KES)',
        'USD' => 'US Dollars(USD)'
    ];
}
