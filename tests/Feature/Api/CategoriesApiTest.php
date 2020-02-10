<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Tests\TestCase;

class CategoriesApiTest extends TestCase
{
    public function test_categories_index()
    {
        $category = Category::orderBy('name')->first();
        $url = route('categories.index');
        $response = $this->actingAs($this->getUser('attendant'))->getJson($url);
        $response->assertStatus(200);
        if ($category) {
            $response->assertJson([
                'data' => [
                    [
                        'id'   => $category->id,
                        'name' => $category->name,
                    ],
                ],
            ]);
        }
    }

    public function test_categories_show()
    {
        $category = Category::all()->random();
        $url = route('categories.show', $category->id);
        $response = $this->actingAs($this->getUser('attendant'))->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'   => $category->id,
            'name' => $category->name,
        ]);
    }

    public function test_categories_store()
    {
        $user = $this->getUser('attendant');
        $category = [
            'name'       => 'Testing New Category',
            'created_by' => $user->id,
        ];
        $url = route('categories.store');
        $response = $this->actingAs($user)->postJson($url, $category);
        $response->assertStatus(201);
        $response->assertJson($category);
        $this->assertDatabaseHas('categories', $category);
    }

    public function test_categories_update()
    {
        $user = $this->getUser('attendant');
        $category = [
            'id'         => factory(Category::class)->create()->id,
            'name'       => 'Testing Update Category',
            'updated_by' => $user->id,
        ];
        $url = route('categories.update', $category['id']);
        $response = $this->actingAs($user)->putJson($url, $category);
        $response->assertStatus(200);
        $response->assertJson($category);
        $this->assertDatabaseHas('categories', $category);
    }

    public function test_categories_destroy()
    {
        $user = $this->getUser('attendant');
        $category = [
            'id'         => factory(Category::class)->create()->id,
            'deleted_by' => $user->id,
        ];
        $url = route('categories.destroy', $category['id']);
        $response = $this->actingAs($user)->deleteJson($url);
        $response->assertStatus(200);
        $response->assertJson($category);
        $this->assertSoftDeleted('categories', $category);
    }
}
