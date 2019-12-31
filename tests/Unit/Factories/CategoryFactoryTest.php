<?php

namespace Tests\Unit\Factories;

use App\Models\Category;
use Tests\TestCase;

class CategoryFactoryTest extends TestCase
{
    public function factory()
    {
        return factory(Category::class)->make();
    }

    public function test_generated_instance_of_the_same_type()
    {
        $category = $this->factory();
        $this->assertInstanceOf(Category::class, $category);
    }

    public function test_generated_instance_exists()
    {
        $category = $this->factory();
        $this->assertIsObject($category);
    }

    public function test_generated_instance_is_saved()
    {
        $before = Category::count();
        $category = $this->factory();
        $status = $category->save();
        $after = Category::count();
        $this->assertTrue($status);
        $this->assertEquals($after - $before, 1);
    }
}
