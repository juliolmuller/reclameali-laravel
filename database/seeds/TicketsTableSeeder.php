<?php

use App\Model\Ticket;
use App\Model\TicketMessage;
use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    public function run()
    {
        factory(Ticket::class, 500)->create()->each(function ($ticket) {
            $lastMessage = $ticket->created_at;
            factory(TicketMessage::class, rand(1, 6))->make([
                'ticket_id'  => $ticket->id,
            ])->each(function ($message, $i) use ($ticket, &$lastMessage) {
                if ($i % 2 === 0)
                    $message->sent_by = $ticket->created_by;
                $message->sent_at = $lastMessage;
                $message->save();
                $lastMessage = $lastMessage->modify("+" . rand(72000, 180000) . " seconds");
            });
        });
    }
}
