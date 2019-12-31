<?php

namespace Tests\Unit\Factories;

use App\Models\User;
use Tests\TestCase;

class UserFactoryTest extends TestCase
{
    public function factory()
    {
        return factory(User::class)->make();
    }

    public function test_generated_instance_of_the_same_type()
    {
        $user = $this->factory();
        $this->assertInstanceOf(User::class, $user);
    }

    public function test_generated_instance_exists()
    {
        $user = $this->factory();
        $this->assertIsObject($user);
    }

    public function test_generated_instance_is_saved()
    {
        $before = User::count();
        $user = $this->factory();
        $status = $user->save();
        $after = User::count();
        $this->assertTrue($status);
        $this->assertEquals($after - $before, 1);
    }
}
