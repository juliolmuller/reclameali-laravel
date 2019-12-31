<?php

use App\Models\TicketStatus;
use Faker\Generator as Faker;

$factory->define(TicketStatus::class, function (Faker $faker) {
    return [
        'name'        => $faker->unique()->word,
        'description' => $faker->text(100),
    ];
});
