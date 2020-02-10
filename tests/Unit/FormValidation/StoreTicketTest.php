<?php

namespace Tests\Unit\FormValidation;

use Tests\TestCase;

class StoreTicketTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const MESSAGE = 'Testing New Message for Ticket';
    const PRODUCT = 1;
    const TYPE = 1;
    const OPEN = 1;
    const CLOSED = 2;

    public function test_required_validation()
    {
        $user = $this->getUser('customer');
        $url = route('tickets.store');
        $response = $this->actingAs($user)->postJson($url);
        $response->assertStatus(422);
        $response = $this->actingAs($user)->postJson($url, [
            'message' => self::MESSAGE,
            'product' => self::PRODUCT,
            'type'    => self::TYPE,
        ]);
        $response->assertStatus(201);
    }

    public function test_required_message_validation()
    {
        $user = $this->getUser('customer');
        $ticket = [
            'product' => self::PRODUCT,
            'type'    => self::TYPE,
        ];
        $url = route('tickets.store');
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(422);
        $ticket['message'] = self::MESSAGE;
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(201);
    }

    public function test_required_product_validation()
    {
        $user = $this->getUser('customer');
        $ticket = [
            'message' => self::MESSAGE,
            'type'    => self::TYPE,
        ];
        $url = route('tickets.store');
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(422);
        $ticket['product'] = self::PRODUCT;
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(201);
    }

    public function test_required_type_validation()
    {
        $user = $this->getUser('customer');
        $ticket = [
            'message' => self::MESSAGE,
            'product' => self::PRODUCT,
        ];
        $url = route('tickets.store');
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(422);
        $ticket['type'] = self::TYPE;
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(201);
    }

    public function test_min_length_message_validation()
    {
        $user = $this->getUser('customer');
        $ticket = [
            'message' => '', // min is 1 character
            'product' => self::PRODUCT,
            'type'    => self::TYPE,
        ];
        $url = route('tickets.store');
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(422);
        $ticket['message'] = self::MESSAGE;
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(201);
    }

    public function test_max_length_message_validation()
    {
        $user = $this->getUser('customer');
        $ticket = [
            'message' => str_repeat('T', 256), // max is 255 characters
            'product' => self::PRODUCT,
            'type'    => self::TYPE,
        ];
        $url = route('tickets.store');
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(422);
        $ticket['message'] = self::MESSAGE;
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(201);
    }

    public function test_exists_product_validation()
    {
        $user = $this->getUser('customer');
        $ticket = [
            'message' => self::MESSAGE,
            'product' => 999999999,
            'type'    => self::TYPE,
        ];
        $url = route('tickets.store');
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(422);
        $ticket['product'] = self::PRODUCT;
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(201);
    }

    public function test_exists_type_validation()
    {
        $user = $this->getUser('customer');
        $ticket = [
            'message' => self::MESSAGE,
            'product' => self::PRODUCT,
            'type'    => 999999999,
        ];
        $url = route('tickets.store');
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(422);
        $ticket['type'] = self::TYPE;
        $response = $this->actingAs($user)->postJson($url, $ticket);
        $response->assertStatus(201);
    }
}
