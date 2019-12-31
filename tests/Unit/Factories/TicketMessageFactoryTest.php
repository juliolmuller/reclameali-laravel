<?php

namespace Tests\Unit\Factories;

use App\Models\TicketMessage as Message;
use Tests\TestCase;

class TicketMessageFactoryTest extends TestCase
{
    public function factory()
    {
        return factory(Message::class)->make();
    }

    public function test_generated_instance_of_the_same_type()
    {
        $message = $this->factory();
        $this->assertInstanceOf(Message::class, $message);
    }

    public function test_generated_instance_exists()
    {
        $message = $this->factory();
        $this->assertIsObject($message);
    }

    public function test_generated_instance_is_saved()
    {
        $before = Message::count();
        $message = $this->factory();
        $status = $message->save();
        $after = Message::count();
        $this->assertTrue($status);
        $this->assertEquals($after - $before, 1);
    }
}
