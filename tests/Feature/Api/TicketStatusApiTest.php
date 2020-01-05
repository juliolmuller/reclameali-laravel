<?php

namespace Tests\Feature\Api;

use App\Models\TicketStatus as Status;
use Tests\TestCase;

class TicketStatusApiTest extends TestCase
{
    public function test_status_index()
    {
        $status = Status::orderBy('name')->first();
        $url = route('ticket-status.index');
        $response = $this->getJson($url);
        $response->assertStatus(200);
        if ($status) {
            $response->assertJson([
                'data' => [
                    [
                        'id'          => $status->id,
                        'name'        => $status->name,
                        'description' => $status->description,
                    ],
                ],
            ]);
        }
    }

    public function test_status_show()
    {
        $status = Status::all()->random();
        $url = route('ticket-status.show', $status->id);
        $response = $this->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'          => $status->id,
            'name'        => $status->name,
            'description' => $status->description,
        ]);
    }

    public function test_status_store()
    {
        $name = 'TESTING_NEW_STATUS';
        $url = route('ticket-status.store');
        $response = $this->postJson($url, compact('name'));
        $response->assertStatus(201);
        $response->assertJson(compact('name'));
        $this->assertDatabaseHas('ticket_status', compact('name'));
    }

    public function test_status_update()
    {
        $id = factory(Status::class)->create()->id;
        $name = 'TESTING_UPDATE_STATUS';
        $url = route('ticket-status.update', $id);
        $response = $this->putJson($url, compact('name'));
        $response->assertStatus(200);
        $response->assertJson(compact('id', 'name'));
        $this->assertDatabaseHas('ticket_status', compact('id', 'name'));
    }

    public function test_status_destroy()
    {
        $id = factory(Status::class)->create()->id;
        $url = route('ticket-status.destroy', $id);
        $response = $this->deleteJson($url);
        $response->assertStatus(200);
        $this->assertSoftDeleted('ticket_status', compact('id'));
        $response->assertJson(compact('id'));
    }
}
