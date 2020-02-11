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
        $response = $this->actingAs($this->getUser('manager'))->getJson($url);
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
        $response = $this->actingAs($this->getUser('manager'))->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'          => $status->id,
            'name'        => $status->name,
            'description' => $status->description,
        ]);
    }

    public function test_status_store()
    {
        $user = $this->getUser('manager');
        $status = [
            'name'       => 'TESTING_NEW_STATUS',
            'created_by' => [
                'id' => $user->id,
            ],
        ];
        $url = route('ticket-status.store');
        $response = $this->actingAs($user)->postJson($url, $status);
        $response->assertStatus(201);
        $response->assertJson($status);
        $this->assertDatabaseHas('ticket_status', $status);
    }

    public function test_status_update()
    {
        $user = $this->getUser('manager');
        $status = [
            'id'         => factory(Status::class)->create()->id,
            'name'       => 'TESTING_UPDATE_STATUS',
            'updated_by' => [
                'id' => $user->id,
            ],
        ];
        $url = route('ticket-status.update', $status['id']);
        $response = $this->actingAs($user)->putJson($url, $status);
        $response->assertStatus(200);
        $response->assertJson($status);
        $this->assertDatabaseHas('ticket_status', $status);
    }

    public function test_status_destroy()
    {
        $user = $this->getUser('manager');
        $status = [
            'id'         => factory(Status::class)->create()->id,
            'deleted_by' => [
                'id' => $user->id,
            ],
        ];
        $url = route('ticket-status.destroy', $status['id']);
        $response = $this->actingAs($user)->deleteJson($url);
        $response->assertStatus(200);
        $response->assertJson($status);
        $this->assertSoftDeleted('ticket_status', $status);
    }
}
