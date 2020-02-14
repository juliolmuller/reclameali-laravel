<?php

use App\Models\Product;
use App\Models\Ticket;
use App\Models\TicketStatus as Status;
use App\Models\TicketType as Type;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    $status = Status::all()->random();
    $openingDate = $faker->dateTimeBetween('-1 year', '-' . (6 * 50) . ' hours');
    $closingDate = $status->name === 'FECHADO' ? $openingDate->modify("+" . (6 * 50) . ' hours') : null;
    return [
        'product_id' => Product::all()->random(),
        'type_id'    => Type::all()->random(),
        'status_id'  => $status,
        'created_at' => $openingDate,
        'closed_at'  => $closingDate,
        'created_by' => User::whereHas('role', function ($q) {
            $q->where('name', 'customer');
        })->get()->random(),
    ];
});
