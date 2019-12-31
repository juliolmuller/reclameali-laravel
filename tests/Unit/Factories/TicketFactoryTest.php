<?php

namespace Tests\Unit\Factories;

use App\Models\Ticket;
use Tests\TestCase;

class TicketFactoryTest extends TestCase
{
    public function factory()
    {
        return factory(Ticket::class)->make();
    }

    public function test_generated_instance_of_the_same_type()
    {
        $ticket = $this->factory();
        $this->assertInstanceOf(Ticket::class, $ticket);
    }

    public function test_generated_instance_exists()
    {
        $ticket = $this->factory();
        $this->assertIsObject($ticket);
    }

    public function test_generated_instance_is_saved()
    {
        $before = Ticket::count();
        $ticket = $this->factory();
        $status = $ticket->save();
        $after = Ticket::count();
        $this->assertTrue($status);
        $this->assertEquals($after - $before, 1);
    }
}
