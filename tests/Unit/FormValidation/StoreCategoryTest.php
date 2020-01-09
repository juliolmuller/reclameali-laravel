<?php

namespace Tests\Unit\FormValidation;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class StoreCategoryTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const NAME = 'Testing Validation on Store';

    private function getUser()
    {
        return User::whereHas('role', function ($query) {
            $query->where('name', 'attendant');
        })->get()->random();
    }

    public function test_required_name_validation()
    {
        $category = [];
        $url = route('categories.store');
        $response = $this->actingAs($this->getUser())->postJson($url, $category);
        $response->assertStatus(422);
        $category['name'] = self::NAME;
        $response = $this->actingAs($this->getUser())->postJson($url, $category);
        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', $category);
    }

    public function test_min_length_name_validation()
    {
        $category = ['name' => 'TT']; // min is 3 characters
        $url = route('categories.store');
        $response = $this->actingAs($this->getUser())->postJson($url, $category);
        $response->assertStatus(422);
        $category['name'] = self::NAME;
        $response = $this->actingAs($this->getUser())->postJson($url, $category);
        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', $category);
    }

    public function test_max_length_name_validation()
    {
        $category = ['name' => str_repeat('T', 51)]; // max is 50 characters
        $url = route('categories.store');
        $response = $this->actingAs($this->getUser())->postJson($url, $category);
        $response->assertStatus(422);
        $category['name'] = self::NAME;
        $response = $this->actingAs($this->getUser())->postJson($url, $category);
        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', $category);
    }

    public function test_unique_name_validation()
    {
        $name = factory(Category::class)->create()->name;
        $category = ['name' => $name];
        $url = route('categories.store');
        $response = $this->actingAs($this->getUser())->postJson($url, $category);
        $response->assertStatus(422);
        $category['name'] = self::NAME;
        $response = $this->actingAs($this->getUser())->postJson($url, $category);
        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', $category);
    }
}
