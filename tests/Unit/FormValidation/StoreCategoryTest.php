<?php

namespace Tests\Unit\FormValidation;

use App\Models\Category;
use Tests\TestCase;

class StoreCategoryTest extends TestCase
{
    public function test_required_validation()
    {
        $before = Category::count();
        $url = route('categories.store');
        $response = $this->postJson($url);
        $after = Category::count();
        $response->assertStatus(422);
        $this->assertEquals($before, $after);
    }

    public function test_min_length_validation()
    {
        $name = 'TT'; // min is 3 characters
        $url = route('categories.store');
        $response = $this->postJson($url, compact('name'));
        $response->assertStatus(422);
        $this->assertDatabaseMissing('categories', compact('name'));
    }

    public function test_max_length_validation()
    {
        $name = str_repeat('T', 51); // max is 50 characters
        $url = route('categories.store');
        $response = $this->postJson($url, compact('name'));
        $response->assertStatus(422);
        $this->assertDatabaseMissing('categories', compact('name'));
    }

    public function test_unique_validation()
    {
        $category = factory(Category::class)->create();
        $name = $category->name;
        $url = route('categories.store');
        $response = $this->postJson($url, compact('name'));
        $response->assertStatus(422);
    }
}
