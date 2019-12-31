<?php

namespace Tests\Unit\Factories;

use App\Models\TicketStatus as Status;
use Tests\TestCase;

class TicketStatusFactoryTest extends TestCase
{
    public function factory()
    {
        return factory(Status::class)->make();
    }

    public function test_generated_instance_of_the_same_type()
    {
        $status = $this->factory();
        $this->assertInstanceOf(Status::class, $status);
    }

    public function test_generated_instance_exists()
    {
        $status = $this->factory();
        $this->assertIsObject($status);
    }

    public function test_generated_instance_is_saved()
    {
        $before = Status::count();
        $status = $this->factory();
        $status = $status->save();
        $after = Status::count();
        $this->assertTrue($status);
        $this->assertEquals($after - $before, 1);
    }
}
