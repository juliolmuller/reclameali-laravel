<?php

namespace Tests\Feature\Api;

use App\Models\TicketType as Type;
use Tests\TestCase;

class TicketTypesApiTest extends TestCase
{
    public function test_type_index()
    {
        $type = Type::orderBy('description')->first();
        $url = route('ticket-types.index');
        $response = $this->getJson($url);
        $response->assertStatus(200);
        if ($type) {
            $response->assertJson([
                'data' => [
                    [
                        'id'          => $type->id,
                        'description' => $type->description,
                    ],
                ],
            ]);
        }
    }

    public function test_type_show()
    {
        $type = Type::all()->random();
        $url = route('ticket-types.show', $type->id);
        $response = $this->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'          => $type->id,
            'description' => $type->description,
        ]);
    }

    public function test_type_store()
    {
        $description = 'Testing New Type';
        $url = route('ticket-types.store');
        $response = $this->postJson($url, compact('description'));
        $response->assertStatus(201);
        $response->assertJson(compact('description'));
        $this->assertDatabaseHas('ticket_types', compact('description'));
    }

    public function test_type_update()
    {
        $id = factory(Type::class)->create()->id;
        $description = 'Testing Update Type';
        $url = route('ticket-types.update', $id);
        $response = $this->putJson($url, compact('description'));
        $response->assertStatus(200);
        $response->assertJson(compact('id', 'description'));
        $this->assertDatabaseHas('ticket_types', compact('id', 'description'));
    }

    public function test_type_destroy()
    {
        $id = factory(Type::class)->create()->id;
        $url = route('ticket-types.destroy', $id);
        $response = $this->deleteJson($url);
        $response->assertStatus(200);
        $this->assertSoftDeleted('ticket_types', compact('id'));
        $response->assertJson(compact('id'));
    }
}
