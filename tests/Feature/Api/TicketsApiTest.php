<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\Ticket;
use App\Models\TicketType as Type;
use Tests\TestCase;

class TicketsApiTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const OPEN = 1;
    const CLOSED = 2;

    public function test_tickets_index()
    {
        $ticket = Ticket::orderByDesc('created_at')->first();
        $url = route('api.tickets.index');
        $response = $this->actingAs($this->getUser('attendant'))->getJson($url);
        $response->assertStatus(200);
        if ($ticket) {
            $response->assertJson([
                'data' => [
                    [
                        'id'         => $ticket->id,
                        'product'    => ['id' => $ticket->product_id],
                        'status'     => ['id' => $ticket->status_id],
                        'type'       => ['id' => $ticket->type_id],
                        'created_by' => ['id' => $ticket->created_by],
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
        $url = route('api.tickets.index');
        $response = $this->actingAs($user)->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                [
                    'id'         => $ticket->id,
                    'product'    => ['id' => $ticket->product_id],
                    'status'     => ['id' => $ticket->status_id],
                    'type'       => ['id' => $ticket->type_id],
                    'created_by' => ['id' => $ticket->created_by],
                ],
            ],
        ]);
    }

    public function test_tickets_show()
    {
        $ticket = Ticket::all()->random();
        $url = route('api.tickets.show', $ticket->id);
        $response = $this->actingAs($this->getUser('attendant'))->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'         => $ticket->id,
            'product'    => ['id' => $ticket->product_id],
            'status'     => ['id' => $ticket->status_id],
            'type'       => ['id' => $ticket->type_id],
            'created_by' => ['id' => $ticket->created_by],
        ]);
    }

    public function test_tickets_show_for_customer()
    {
        do {
            $user = $this->getUser('customer');
        } while (!$user->tickets->count());
        $ticket = Ticket::where('created_by', '<>', $user->id)->get()->random();
        $url = route('api.tickets.show', $ticket->id);
        $response = $this->actingAs($user)->getJson($url);
        $response->assertStatus(403);
        $ticket = $user->tickets[0];
        $url = route('api.tickets.show', $ticket->id);
        $response = $this->actingAs($user)->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'         => $ticket->id,
            'product'    => ['id' => $ticket->product_id],
            'status'     => ['id' => $ticket->status_id],
            'type'       => ['id' => $ticket->type_id],
            'created_by' => ['id' => $ticket->created_by],
        ]);
    }

    public function test_tickets_store()
    {
        $user = $this->getUser('customer');
        $ticket = [
            'product' => Product::all()->random()->id,
            'type'    => Type::all()->random()->id,
            'user'    => $user->id,
            'message' => 'Testing new message'
        ];
        $url = route('api.tickets.store');
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(201);
        $response->assertJson([
            'product'    => ['id' => $ticket['product']],
            'status'     => ['id' => self::OPEN],
            'type'       => ['id' => $ticket['type']],
            'created_by' => ['id' => $ticket['user']],
            'messages'   => [
                [
                    'body' => $ticket['message'],
                ],
            ],
        ]);
        unset($ticket['messages']);
        $this->assertDatabaseHas('tickets', [
            'product_id' => $ticket['product'],
            'status_id'  => self::OPEN,
            'type_id'    => $ticket['type'],
            'created_by' => $ticket['user'],
        ]);
    }

    public function test_tickets_update()
    {
        $user = $this->getUser('attendant');
        $ticket = factory(Ticket::class)->create(['status_id' => self::OPEN, 'created_by' => $user->id]);
        $message = 'Testing new message';
        $url = route('api.tickets.update', $ticket->id);
        $response = $this->actingAs($user)->putJson($url, compact('message'));
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $ticket->id,
            'messages' => [
                [
                    'body'    => $message,
                    'sent_by' => [
                        'id' => $user->id,
                    ],
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
        $url = route('api.tickets.update', $ticket->id);
        $response = $this->actingAs($user)->putJson($url, compact('message'));
        $response->assertStatus(404);
        $ticket = $user->tickets[0];
        $url = route('api.tickets.update', $ticket->id);
        $response = $this->actingAs($user)->putJson($url, compact('message'));
        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_messages', [
            'ticket_id' => $ticket->id,
            'body'      => $message,
            'sent_by'   => [
                'id' => $user->id,
            ],
        ]);
    }

    public function test_tickets_close()
    {
        $ticket = factory(Ticket::class)->create();
        $user = $this->getUser('attendant');
        $url = route('api.tickets.close', $ticket->id);
        $response = $this->actingAs($user)->patchJson($url, []);
        $response->assertStatus(200);
        $response->assertJson([
            'product'    => ['id' => $ticket->product_id],
            'status'     => ['id' => self::CLOSED],
            'type'       => ['id' => $ticket->type_id],
            'created_by' => ['id' => $ticket->created_by],
        ]);
    }
}
