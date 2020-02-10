<?php

namespace Tests\Unit\FormValidation;

use App\Models\TicketStatus as Status;
use Tests\TestCase;

class UpdateTicketStatusTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const NAME = 'TESTING_VALIDATION_ON_STORE';

    public function test_required_name_validation()
    {
        $status = [];
        $id = factory(Status::class)->create()->id;
        $url = route('ticket-status.update', $id);
        $response = $this->actingAs($this->getUser('manager'))->putJson($url, $status);
        $response->assertStatus(422);
        $status['name'] = self::NAME;
        $response = $this->actingAs($this->getUser('manager'))->putJson($url, $status);
        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_status', $status);
    }

    public function test_min_length_name_validation()
    {
        $status = ['name' => '']; // min is 1 characters
        $id = factory(Status::class)->create()->id;
        $url = route('ticket-status.update', $id);
        $response = $this->actingAs($this->getUser('manager'))->putJson($url, $status);
        $response->assertStatus(422);
        $status['name'] = self::NAME;
        $response = $this->actingAs($this->getUser('manager'))->putJson($url, $status);
        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_status', $status);
    }

    public function test_max_length_name_validation()
    {
        $status = ['name' => str_repeat('A', 31)]; // max is 30 characters
        $id = factory(Status::class)->create()->id;
        $url = route('ticket-status.update', $id);
        $response = $this->actingAs($this->getUser('manager'))->putJson($url, $status);
        $response->assertStatus(422);
        $status['name'] = self::NAME;
        $response = $this->actingAs($this->getUser('manager'))->putJson($url, $status);
        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_status', $status);
    }

    public function test_unique_name_validation()
    {
        $name = factory(Status::class)->create()->name;
        $status = ['name' => $name];
        $id = factory(Status::class)->create()->id;
        $url = route('ticket-status.update', $id);
        $response = $this->actingAs($this->getUser('manager'))->putJson($url, $status);
        $response->assertStatus(422);
        $status['name'] = self::NAME;
        $response = $this->actingAs($this->getUser('manager'))->putJson($url, $status);
        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_status', $status);
    }

    public function test_max_length_description_validation()
    {
        $status = [
            'name' => self::NAME,
            'description' => str_repeat('A', 256), // max is 255 characters
        ];
        $id = factory(Status::class)->create()->id;
        $url = route('ticket-status.update', $id);
        $response = $this->actingAs($this->getUser('manager'))->putJson($url, $status);
        $response->assertStatus(422);
        $status['description'] = str_repeat('A', 255);
        $response = $this->actingAs($this->getUser('manager'))->putJson($url, $status);
        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_status', $status);
    }
}
