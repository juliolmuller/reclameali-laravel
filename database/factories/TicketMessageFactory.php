<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\User;
use App\Model\Ticket;
use App\Model\TicketMessage;
use Faker\Generator as Faker;

$factory->define(TicketMessage::class, function (Faker $faker) {
    return [
        'ticket_id'    => Ticket::all()->random()->id,
        'message_body' => $faker->text(255),
        'sent_at'      => $faker->dateTimeBetween('-1 year'),
        'sent_by'      => User::whereHas('role', function ($q) {
            $q->where('name', 'attendant');
        })->get()->random()->id,
    ];
});
