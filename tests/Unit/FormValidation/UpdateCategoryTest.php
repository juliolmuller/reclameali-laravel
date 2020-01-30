<?php

namespace Tests\Unit\FormValidation;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const NAME = 'Testing Validation on Store';

    public function test_required_name_validation()
    {
        $category = [];
        $id = factory(Category::class)->create()->id;
        $url = route('categories.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $category);
        $response->assertStatus(422);
        $category['name'] = self::NAME;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $category);
        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', $category);
    }

    public function test_min_length_name_validation()
    {
        $category = ['name' => 'TT']; // min is 3 characters
        $id = factory(Category::class)->create()->id;
        $url = route('categories.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $category);
        $response->assertStatus(422);
        $category['name'] = self::NAME;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $category);
        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', $category);
    }

    public function test_max_length_name_validation()
    {
        $category = ['name' => str_repeat('T', 51)]; // max is 50 characters
        $id = factory(Category::class)->create()->id;
        $url = route('categories.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $category);
        $response->assertStatus(422);
        $category['name'] = self::NAME;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $category);
        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', $category);
    }

    public function test_unique_name_validation()
    {
        $name = factory(Category::class)->create()->name;
        $category = ['name' => $name];
        $id = factory(Category::class)->create()->id;
        $url = route('categories.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $category);
        $response->assertStatus(422);
        $category['name'] = self::NAME;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $category);
        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', $category);
    }
}
