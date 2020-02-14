<?php

use App\Models\TicketStatus;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(TicketStatus::class, function (Faker $faker) {

    return [
        'name'        => Str::upper($faker->unique()->word),
        'description' => $faker->text(100),
    ];

});
