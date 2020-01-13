<?php

namespace Tests\Unit\FormValidation;

use App\Models\User;
use Tests\TestCase;

class StoreTicketMessageTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const MESSAGE = 'Testing New Message for Ticket';

    private function getUser($user)
    {
        return User::whereHas('role', function ($query) use ($user) {
            $query->where('name', $user);
        })->get()->random();
    }

    public function test_required_message_validation()
    {
        do {
            $user = $this->getUser('customer');
        } while (!$user->tickets->count());
        $url = route('tickets.update', $user->tickets[0]->id);
        $response = $this->actingAs($user)->putJson($url, []);
        $response->assertStatus(422);
        $response = $this->actingAs($user)->putJson($url, ['message' => self::MESSAGE]);
        $response->assertStatus(200);
    }

    public function test_min_length_message_validation()
    {
        do {
            $user = $this->getUser('customer');
        } while (!$user->tickets->count());
        $url = route('tickets.update', $user->tickets[0]->id);
        $response = $this->actingAs($user)->putJson($url, ['message' => '']);
        $response->assertStatus(422);
        $response = $this->actingAs($user)->putJson($url, ['message' => self::MESSAGE]);
        $response->assertStatus(200);
    }

    public function test_max_length_message_validation()
    {
        do {
            $user = $this->getUser('customer');
        } while (!$user->tickets->count());
        $url = route('tickets.update', $user->tickets[0]->id);
        $response = $this->actingAs($user)->putJson($url, ['message' => str_repeat('T', 256)]);
        $response->assertStatus(422);
        $response = $this->actingAs($user)->putJson($url, ['message' => self::MESSAGE]);
        $response->assertStatus(200);
    }
}
