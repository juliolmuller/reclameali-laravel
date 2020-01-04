<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class ProductsApiTest extends TestCase
{
    public function test_products_index()
    {
        $product = Product::orderBy('name')->first();
        $url = route('products.index');
        $response = $this->getJson($url);
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
        $response = $this->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'   => $product->id,
            'name' => $product->name,
        ]);
    }

    public function test_products_store()
    {
        $categoryId = Category::all()->random()->id;
        $product = [
            'name'        => 'Testing New Product',
            'description' => 'Testing New Product',
            'category_id' => $categoryId,
            'category'    => $categoryId,
            'utc'         => '000000000000',
            'ean'         => '0000000000000',
        ];
        $url = route('products.store');
        $response = $this->postJson($url, $product);
        $response->assertStatus(201);
        $product['category'] = ['id' => $categoryId];
        $response->assertJson($product);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_products_update()
    {
        $categoryId = Category::all()->random()->id;
        $product = [
            'id'          => factory(Product::class)->create()->id,
            'name'        => 'Testing New Product',
            'description' => 'Testing New Product',
            'category_id' => $categoryId,
            'category'    => $categoryId,
            'utc'         => '000000000000',
            'ean'         => '0000000000000',
        ];
        $url = route('products.update', $product['id']);
        $response = $this->putJson($url, $product);
        $response->assertStatus(200);
        $product['category'] = ['id' => $categoryId];
        $response->assertJson($product);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_products_destroy()
    {
        $id = factory(Product::class)->create()->id;
        $url = route('products.destroy', $id);
        $response = $this->deleteJson($url);
        $response->assertStatus(200);
        $this->assertSoftDeleted('products', compact('id'));
        $response->assertJson(compact('id'));
    }
}
