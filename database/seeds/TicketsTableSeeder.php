<?php

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    /**
     * Seed the database table
     *
     * @return void
     */
    public function run()
    {
        factory(Ticket::class, 500)->create()->each(function ($ticket) {

            $lastMessage = $ticket->created_at;

            factory(TicketMessage::class, rand(1, 6))
                ->make(['ticket_id' => $ticket->id])
                ->each(function ($message, $i) use ($ticket, &$lastMessage) {

                    $message->sent_at = $lastMessage;
                    if ($i % 2 === 0) {
                        $message->sent_by = $ticket->created_by;
                    }
                    $message->save();

                    $lastMessage = $lastMessage->modify("+" . rand(72000, 180000) . " seconds");
                });
        });
    }
}
