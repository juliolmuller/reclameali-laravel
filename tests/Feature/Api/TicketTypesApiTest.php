<?php

namespace Tests\Feature\Api;

use App\Models\TicketType as Type;
use Tests\TestCase;

class TicketTypesApiTest extends TestCase
{
    public function test_type_index()
    {
        $type = Type::orderBy('description')->first();
        $url = route('api.ticket_types.index');
        $response = $this->actingAs($this->getUser('manager'))->getJson($url);
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
        $url = route('api.ticket_types.show', $type->id);
        $response = $this->actingAs($this->getUser('manager'))->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'          => $type->id,
            'description' => $type->description,
        ]);
    }

    public function test_type_store()
    {
        $user = $this->getUser('manager');
        $type = [
            'description' => 'Testing New Type',
            'created_by'  => [
                'id' => $user->id,
            ],
        ];
        $url = route('api.ticket_types.store');
        $response = $this->actingAs($user)->postJson($url, $type);
        $response->assertStatus(201);
        $response->assertJson($type);
        $this->assertDatabaseHas('ticket_types', $type);
    }

    public function test_type_update()
    {
        $user = $this->getUser('manager');
        $type = [
            'id'          => factory(Type::class)->create()->id,
            'description' => 'Testing Update Type',
            'updated_by'  => [
                'id' => $user->id,
            ],
        ];
        $url = route('api.ticket_types.update', $type['id']);
        $response = $this->actingAs($user)->putJson($url, $type);
        $response->assertStatus(200);
        $response->assertJson($type);
        $this->assertDatabaseHas('ticket_types', $type);
    }

    public function test_type_destroy()
    {
        $user = $this->getUser('manager');
        $type = [
            'id'         => factory(Type::class)->create()->id,
            'deleted_by' => [
                'id' => $user->id,
            ],
        ];
        $url = route('api.ticket_types.destroy', $type['id']);
        $response = $this->actingAs($user)->deleteJson($url);
        $response->assertStatus(200);
        $response->assertJson($type);
        $this->assertSoftDeleted('ticket_types', $type);
    }
}
