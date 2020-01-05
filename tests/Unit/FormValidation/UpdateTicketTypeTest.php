<?php

namespace Tests\Unit\FormValidation;

use App\Models\TicketType as Type;
use Tests\TestCase;

class UpdateTicketTypeTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const DESCRIPTION = 'Testing Validation on Store';

    public function test_required_description_validation()
    {
        $type = [];
        $id = factory(Type::class)->create()->id;
        $url = route('ticket-types.update', $id);
        $response = $this->putJson($url, $type);
        $response->assertStatus(422);
        $type['description'] = self::DESCRIPTION;
        $response = $this->putJson($url, $type);
        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_types', $type);
    }

    public function test_min_length_description_validation()
    {
        $type = ['description' => '']; // min is 1 characters
        $id = factory(Type::class)->create()->id;
        $url = route('ticket-types.update', $id);
        $response = $this->putJson($url, $type);
        $response->assertStatus(422);
        $type['description'] = self::DESCRIPTION;
        $response = $this->putJson($url, $type);
        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_types', $type);
    }

    public function test_max_length_description_validation()
    {
        $type = ['description' => str_repeat('A', 256)]; // max is 255 characters
        $id = factory(Type::class)->create()->id;
        $url = route('ticket-types.update', $id);
        $response = $this->putJson($url, $type);
        $response->assertStatus(422);
        $type['description'] = str_repeat('A', 255);
        $response = $this->putJson($url, $type);
        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_types', $type);
    }

    public function test_unique_description_validation()
    {
        $description = factory(Type::class)->create()->description;
        $type = ['description' => $description];
        $id = factory(Type::class)->create()->id;
        $url = route('ticket-types.update', $id);
        $response = $this->putJson($url, $type);
        $response->assertStatus(422);
        $type['description'] = self::DESCRIPTION;
        $response = $this->putJson($url, $type);
        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_types', $type);
    }
}
