<?php

namespace Tests\Unit\Factories;

use App\Model\TicketType as Type;
use Tests\TestCase;

class TicketTypeFactoryTest extends TestCase
{
    public function factory()
    {
        return factory(Type::class)->make();
    }

    public function test_generated_instance_of_the_same_type()
    {
        $type = $this->factory();
        $this->assertInstanceOf(Type::class, $type);
    }

    public function test_generated_instance_exists()
    {
        $type = $this->factory();
        $this->assertIsObject($type);
    }

    public function test_generated_instance_is_saved()
    {
        $before = Type::count();
        $type = $this->factory();
        $status = $type->save();
        $after = Type::count();
        $this->assertTrue($status);
        $this->assertEquals($after - $before, 1);
    }
}
