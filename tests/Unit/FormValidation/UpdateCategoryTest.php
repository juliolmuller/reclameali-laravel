<?php

namespace Tests\Unit\FormValidation;

use App\Models\Category;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    public function test_required_validation()
    {
        $category = factory(Category::class)->create();
        $id = $category->id;
        $name = $category->name;
        $url = route('categories.update', $id);
        $response = $this->putJson($url);
        $response->assertStatus(422);
        $this->assertDatabaseHas('categories', compact('id', 'name'));
    }

    public function test_min_length_validation()
    {
        $category = factory(Category::class)->create();
        $id = $category->id;
        $oldName = $category->name;
        $newName = 'TT'; // min is 3 characters
        $url = route('categories.update', $id);
        $response = $this->putJson($url, ['name' => $newName]);
        $response->assertStatus(422);
        $this->assertDatabaseHas('categories', ['id' => $id, 'name' => $oldName]);
        $this->assertDatabaseMissing('categories', ['id' => $id, 'name' => $newName]);
    }

    public function test_max_length_validation()
    {
        $category = factory(Category::class)->create();
        $id = $category->id;
        $oldName = $category->name;
        $newName = str_repeat('T', 51); // max is 50 characters
        $url = route('categories.update', $id);
        $response = $this->putJson($url, ['name' => $newName]);
        $response->assertStatus(422);
        $this->assertDatabaseHas('categories', ['id' => $id, 'name' => $oldName]);
        $this->assertDatabaseMissing('categories', ['id' => $id, 'name' => $newName]);
    }

    public function test_unique_validation()
    {
        $name = Category::all()->random()->name;
        $category = factory(Category::class)->create();
        $id = $category->id;
        $url = route('categories.update', $id);
        $response = $this->putJson($url, compact('name'));
        $response->assertStatus(422);
        $this->assertDatabaseMissing('categories', compact('id', 'name'));
    }
}
