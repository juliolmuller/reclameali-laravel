<?php

use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Faker\Generator as Faker;

$factory->define(TicketMessage::class, function (Faker $faker) {
    return [
        'ticket_id' => Ticket::all()->random(),
        'body'      => $faker->text(255),
        'sent_at'   => $faker->dateTimeBetween('-1 year'),
        'sent_by'   => User::whereHas('role', function ($query) {
            $query->where('name', 'attendant');
        })->get()->random(),
    ];
});
