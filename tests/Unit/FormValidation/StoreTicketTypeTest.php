<?php

namespace Tests\Unit\FormValidation;

use App\Models\TicketType as Type;
use Tests\TestCase;

class StoreTicketTypeTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const DESCRIPTION = 'Testing Validation on Store';

    public function test_required_description_validation()
    {
        $type = [];
        $url = route('ticket-types.store');
        $response = $this->postJson($url, $type);
        $response->assertStatus(422);
        $type['description'] = self::DESCRIPTION;
        $response = $this->postJson($url, $type);
        $response->assertStatus(201);
        $this->assertDatabaseHas('ticket_types', $type);
    }

    public function test_min_length_description_validation()
    {
        $type = ['description' => '']; // min is 1 characters
        $url = route('ticket-types.store');
        $response = $this->postJson($url, $type);
        $response->assertStatus(422);
        $type['description'] = self::DESCRIPTION;
        $response = $this->postJson($url, $type);
        $response->assertStatus(201);
        $this->assertDatabaseHas('ticket_types', $type);
    }

    public function test_max_length_description_validation()
    {
        $type = ['description' => str_repeat('A', 256)]; // max is 255 characters
        $url = route('ticket-types.store');
        $response = $this->postJson($url, $type);
        $response->assertStatus(422);
        $type['description'] = str_repeat('A', 255);
        $response = $this->postJson($url, $type);
        $response->assertStatus(201);
        $this->assertDatabaseHas('ticket_types', $type);
    }

    public function test_unique_description_validation()
    {
        $description = factory(Type::class)->create()->description;
        $type = ['description' => $description];
        $url = route('ticket-types.store');
        $response = $this->postJson($url, $type);
        $response->assertStatus(422);
        $type['description'] = self::DESCRIPTION;
        $response = $this->postJson($url, $type);
        $response->assertStatus(201);
        $this->assertDatabaseHas('ticket_types', $type);
    }
}
