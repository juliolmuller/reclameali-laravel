<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class ProductsApiTest extends TestCase
{
    private function getUser()
    {
        return User::whereHas('role', function ($query) {
            $query->where('name', 'attendant');
        })->get()->random();
    }

    public function test_products_index()
    {
        $product = Product::orderBy('name')->first();
        $url = route('products.index');
        $response = $this->actingAs($this->getUser())->getJson($url);
        $response->assertStatus(200);
        if ($product) {
            $response->assertJson([
                'data' => [
                    [
                        'id'   => $product->id,
                        'name' => $product->name,
                    ],
                ],
            ]);
        }
    }

    public function test_products_show()
    {
        $product = Product::all()->random();
        $url = route('products.show', $product->id);
        $response = $this->actingAs($this->getUser())->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'   => $product->id,
            'name' => $product->name,
        ]);
    }

    public function test_products_store()
    {
        $categoryId = Category::all()->random()->id;
        $user = $this->getUser();
        $product = [
            'name'        => 'Testing New Product',
            'category_id' => $categoryId,
            'category'    => $categoryId,
            'utc'         => '000000000000',
            'created_by' => $user->id,
        ];
        $url = route('products.store');
        $response = $this->actingAs($user)->postJson($url, $product);
        $response->assertStatus(201);
        $product['category'] = ['id' => $categoryId];
        $response->assertJson($product);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_products_update()
    {
        $categoryId = Category::all()->random()->id;
        $user = $this->getUser();
        $product = [
            'id'          => factory(Product::class)->create()->id,
            'name'        => 'Testing New Product',
            'category_id' => $categoryId,
            'category'    => $categoryId,
            'utc'         => '000000000000',
            'updated_by' => $user->id,
        ];
        $url = route('products.update', $product['id']);
        $response = $this->actingAs($user)->putJson($url, $product);
        $response->assertStatus(200);
        $product['category'] = ['id' => $categoryId];
        $response->assertJson($product);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_products_destroy()
    {
        $user = $this->getUser();
        $product = [
            'id'         => factory(Product::class)->create()->id,
            'deleted_by' => $user->id,
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.destroy', $product['id']);
        $response = $this->actingAs($user)->deleteJson($url);
        $response->assertStatus(200);
        $response->assertJson($product);
        $this->assertSoftDeleted('products', $product);
    }
}
