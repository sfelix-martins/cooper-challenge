<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'amount' => $faker->numberBetween(0, 100),
        'value' => $faker->randomFloat(2, 1, 1000),
    ];
});
