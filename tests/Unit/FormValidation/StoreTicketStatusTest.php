<?php

namespace Tests\Unit\FormValidation;

use App\Models\TicketStatus as Status;
use App\Models\User;
use Tests\TestCase;

class StoreTicketStatusTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const NAME = 'TESTING_VALIDATION_ON_STORE';

    private function getUser()
    {
        return User::whereHas('role', function ($query) {
            $query->where('name', 'manager');
        })->get()->random();
    }

    public function test_required_name_validation()
    {
        $status = [];
        $url = route('ticket-status.store');
        $response = $this->actingAs($this->getUser())->postJson($url, $status);
        $response->assertStatus(422);
        $status['name'] = self::NAME;
        $response = $this->actingAs($this->getUser())->postJson($url, $status);
        $response->assertStatus(201);
        $this->assertDatabaseHas('ticket_status', $status);
    }

    public function test_min_length_name_validation()
    {
        $status = ['name' => '']; // min is 1 characters
        $url = route('ticket-status.store');
        $response = $this->actingAs($this->getUser())->postJson($url, $status);
        $response->assertStatus(422);
        $status['name'] = self::NAME;
        $response = $this->actingAs($this->getUser())->postJson($url, $status);
        $response->assertStatus(201);
        $this->assertDatabaseHas('ticket_status', $status);
    }

    public function test_max_length_name_validation()
    {
        $status = ['name' => str_repeat('A', 31)]; // max is 30 characters
        $url = route('ticket-status.store');
        $response = $this->actingAs($this->getUser())->postJson($url, $status);
        $response->assertStatus(422);
        $status['name'] = self::NAME;
        $response = $this->actingAs($this->getUser())->postJson($url, $status);
        $response->assertStatus(201);
        $this->assertDatabaseHas('ticket_status', $status);
    }

    public function test_unique_name_validation()
    {
        $name = factory(Status::class)->create()->name;
        $status = ['name' => $name];
        $url = route('ticket-status.store');
        $response = $this->actingAs($this->getUser())->postJson($url, $status);
        $response->assertStatus(422);
        $status['name'] = self::NAME;
        $response = $this->actingAs($this->getUser())->postJson($url, $status);
        $response->assertStatus(201);
        $this->assertDatabaseHas('ticket_status', $status);
    }

    public function test_max_length_description_validation()
    {
        $status = [
            'name'        => self::NAME,
            'description' => str_repeat('T', 256), // max is 255 characters
        ];
        $url = route('ticket-status.store');
        $response = $this->actingAs($this->getUser())->postJson($url, $status);
        $response->assertStatus(422);
        $status['description'] = str_repeat('T', 255);
        $response = $this->actingAs($this->getUser())->postJson($url, $status);
        $response->assertStatus(201);
        $this->assertDatabaseHas('ticket_status', $status);
    }
}
