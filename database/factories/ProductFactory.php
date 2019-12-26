<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'        => $faker->unique()->productName,
        'description' => $faker->optional()->paragraphs(3, true),
        'weight'      => $faker->optional()->numberBetween(15, 1000),
        'utc'         => $faker->unique()->numerify(str_repeat('#', 12)),
        'ean'         => $faker->optional()->ean13,
    ];
});
