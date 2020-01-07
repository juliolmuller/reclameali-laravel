<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\Ticket;
use App\Models\TicketMessage as Message;
use App\Models\TicketStatus as Status;
use App\Models\TicketType as Type;
use App\Models\User;
use Tests\TestCase;

class TicketsApiTest extends TestCase
{
    private function toModel(array $ticket)
    {
        return [
            'product_id' => $ticket['product'],
            'status_id'  => $ticket['status'],
            'type_id'    => $ticket['type'],
            'created_by' => $ticket['user'],
            'messages'   => [
                [
                    'body' => $ticket['message'],
                ],
            ],
        ];
    }

    public function test_tickets_index()
    {
        $ticket = Ticket::orderBy('created_at', 'desc')->first();
        $url = route('tickets.index');
        $response = $this->getJson($url);
        $response->assertStatus(200);
        if ($ticket) {
            $response->assertJson([
                'data' => [
                    [
                        'id'         => $ticket->id,
                        'product_id' => $ticket->product_id,
                        'status_id'  => $ticket->status_id,
                        'type_id'    => $ticket->type_id,
                        'created_by' => $ticket->created_by,
                    ],
                ],
            ]);
        }
    }

    public function test_tickets_show()
    {
        $ticket = Ticket::all()->random();
        $url = route('tickets.show', $ticket->id);
        $response = $this->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'         => $ticket->id,
            'product_id' => $ticket->product_id,
            'status_id'  => $ticket->status_id,
            'type_id'    => $ticket->type_id,
            'created_by' => $ticket->created_by,
        ]);
    }

    public function test_tickets_store()
    {
        $ticket = [
            'product' => Product::all()->random()->id,
            'status'  => Status::all()->random()->id,
            'type'    => Type::all()->random()->id,
            'user'    => User::all()->random()->id,
            'message' => 'Testing new message'
        ];
        $url = route('tickets.store');
        $response = $this->postJson($url, $ticket);
        $response->assertStatus(201);
        $ticket = $this->toModel($ticket);
        $response->assertJson($ticket);
        unset($ticket['messages']);
        $this->assertDatabaseHas('tickets', $ticket);
    }

    public function test_tickets_update()
    {
        $ticket = factory(Ticket::class)->create();
        $message = [
            'user'      => $ticket->created_by,
            'message'   => 'Testing new message'
        ];
        $url = route('tickets.update', $ticket->id);
        $response = $this->putJson($url, $message);
        $response->assertStatus(200);
        $response->assertJson(['id' => $ticket->id]);
        unset($ticket['messages']);
        $this->assertDatabaseHas('ticket_messages', [
            'ticket_id' => $ticket->id,
            'body'      => $message['message'],
        ]);
    }

    public function test_tickets_close()
    {
        $ticket = factory(Ticket::class)->create();
        $url = route('tickets.close', $ticket->id);
        $response = $this->patchJson($url, [
            'user' => User::with('role')->where('role_id', '<>', 1)->get()->random()
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'product_id' => $ticket->product_id,
            'status_id'  => $ticket->status_id,
            'type_id'    => $ticket->type_id,
            'created_by' => $ticket->created_by,
        ]);
    }
}
