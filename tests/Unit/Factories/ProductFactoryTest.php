<?php

namespace Tests\Unit\Factories;

use App\Model\Product;
use Tests\TestCase;

class ProductFactoryTest extends TestCase
{
    public function factory()
    {
        return factory(Product::class)->make();
    }

    public function test_generated_instance_of_the_same_type()
    {
        $product = $this->factory();
        $this->assertInstanceOf(Product::class, $product);
    }

    public function test_generated_instance_exists()
    {
        $product = $this->factory();
        $this->assertIsObject($product);
    }

    public function test_generated_instance_is_saved()
    {
        $before = Product::count();
        $product = $this->factory();
        $status = $product->save();
        $after = Product::count();
        $this->assertTrue($status);
        $this->assertEquals($after - $before, 1);
    }
}
