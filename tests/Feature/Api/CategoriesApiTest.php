<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesApiTest extends TestCase
{
    public function test_categories_index()
    {
        $url = route('categories.index');
        $response = $this->getJson($url);
        $response->assertStatus(200);
    }

    public function test_categories_show()
    {
        $category = Category::all()->random()->id;
        $url = route('categories.show', compact('category'));
        $response = $this->getJson($url);
        $response->assertStatus(200);
    }

    public function test_categories_store()
    {
        $name = 'Testing New Category';
        $url = route('categories.store');
        $response = $this->postJson($url, compact('name'));
        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', compact('name'));
    }

    public function test_categories_update()
    {
        $id = $category = Category::all()->random()->id;
        $name = 'Testing New Category';
        $url = route('categories.update', compact('category'));
        $response = $this->putJson($url, compact('name'));
        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', compact('id', 'name'));
    }

    public function test_categories_destroy()
    {
        $id = $category = Category::all()->random()->id;
        $url = route('categories.destroy', compact('category'));
        $response = $this->deleteJson($url);
        $response->assertStatus(200);
        $this->assertSoftDeleted('categories', compact('id'));
    }
}
