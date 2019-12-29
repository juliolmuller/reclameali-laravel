<?php

use App\Model\TicketType;
use Faker\Generator as Faker;

$factory->define(TicketType::class, function (Faker $faker) {
    return [
        'description' => $faker->unique()->word,
    ];
});
