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
    private function getUser($user)
    {
        return User::whereHas('role', function ($query) use ($user) {
            $query->where('name', $user);
        })->get()->random();
    }

    public function test_tickets_index()
    {
        $ticket = Ticket::orderBy('created_at', 'desc')->first();
        $url = route('tickets.index');
        $response = $this->actingAs($this->getUser('attendant'))->getJson($url);
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

    public function test_tickets_index_for_customer()
    {
        do {
            $user = $this->getUser('customer');
        } while (!$user->tickets->count());
        $ticket = $user->tickets[0];
        $url = route('tickets.index');
        $response = $this->actingAs($user)->getJson($url);
        $response->assertStatus(200);
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

    public function test_tickets_show()
    {
        $ticket = Ticket::all()->random();
        $url = route('tickets.show', $ticket->id);
        $response = $this->actingAs($this->getUser('attendant'))->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'         => $ticket->id,
            'product_id' => $ticket->product_id,
            'status_id'  => $ticket->status_id,
            'type_id'    => $ticket->type_id,
            'created_by' => $ticket->created_by,
        ]);
    }

    public function test_tickets_show_for_customer()
    {
        do {
            $user = $this->getUser('customer');
        } while (!$user->tickets->count());
        $ticket = Ticket::where('created_by', '<>', $user->id)->get()->random();
        $url = route('tickets.show', $ticket->id);
        $response = $this->actingAs($user)->getJson($url);
        $response->assertStatus(403);
        $ticket = $user->tickets[0];
        $url = route('tickets.show', $ticket->id);
        $response = $this->actingAs($user)->getJson($url);
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
        $user = $this->getUser('customer');
        $ticket = [
            'product' => Product::all()->random()->id,
            'status'  => Status::all()->random()->id,
            'type'    => Type::all()->random()->id,
            'user'    => $user->id,
            'message' => 'Testing new message'
        ];
        $url = route('tickets.store');
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(201);
        $ticket = [
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
        $response->assertJson($ticket);
        unset($ticket['messages']);
        $this->assertDatabaseHas('tickets', $ticket);
    }

    public function test_tickets_update()
    {
        $user = $this->getUser('attendant');
        $ticket = factory(Ticket::class)->create(['created_by' => $user->id]);
        $message = 'Testing new message';
        $url = route('tickets.update', $ticket->id);
        $response = $this->actingAs($user)->putJson($url, compact('message'));
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $ticket->id,
            'messages' => [
                [
                    'body'    => $message,
                    'sent_by' => $user->id,
                ],
            ],
        ]);
        $this->assertDatabaseHas('ticket_messages', [
            'ticket_id' => $ticket->id,
            'body'      => $message,
            'sent_by'   => $user->id,
        ]);
    }

    public function test_tickets_update_for_customer()
    {
        do {
            $user = $this->getUser('customer');
        } while (!$user->tickets->count());
        $message = 'Testing new message';
        $ticket = Ticket::where('created_by', '<>', $user->id)->get()->random();
        $url = route('tickets.update', $ticket->id);
        $response = $this->actingAs($user)->putJson($url, compact('message'));
        $response->assertStatus(403);
        $ticket = $user->tickets[0];
        $url = route('tickets.update', $ticket->id);
        $response = $this->actingAs($user)->putJson($url, compact('message'));
        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_messages', [
            'ticket_id' => $ticket->id,
            'body'      => $message,
            'sent_by'   => $user->id,
        ]);
    }

    public function test_tickets_close()
    {
        $ticket = factory(Ticket::class)->create();
        $user = $this->getUser('attendant');
        $url = route('tickets.close', $ticket->id);
        $response = $this->actingAs($user)->patchJson($url, []);
        $response->assertStatus(200);
        $response->assertJson([
            'product_id' => $ticket->product_id,
            'status_id'  => $ticket->status_id,
            'type_id'    => $ticket->type_id,
            'created_by' => $ticket->created_by,
        ]);
    }
}
