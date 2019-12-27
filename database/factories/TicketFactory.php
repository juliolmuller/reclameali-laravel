<?php

use App\Model\Product;
use App\Model\Ticket;
use App\Model\TicketStatus as Status;
use App\Model\TicketType as Type;
use App\Model\User;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    $status = Status::all()->random();
    $openingDate = $faker->dateTimeBetween('-1 year', '-' . (6 * 50) . ' hours');
    $closingDate = $status->name === 'CLOSED' ? $openingDate->modify("+" . (6 * 50) . ' hours') : null;
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
