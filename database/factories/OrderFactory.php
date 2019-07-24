<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Order;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $address = [
        'zipcode' => $faker->postcode,
        'uf' => $faker->stateAbbr,
        'city' => $faker->city,
        'address' => $faker->address,
        'number' => $faker->buildingNumber,
    ];
    $amount = $faker->numberBetween(1, 20);

    return [
        'product_id' => function () use ($amount) {
            return factory(Product::class)->create([
                'amount' => $amount + 1,
            ])->id;
        },
        'amount' => $amount,
        'requester_name' => $faker->name,
        'requester_address' => json_encode($address),
        'forwarding_agent_name' => $faker->name,
    ];
});
