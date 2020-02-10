<?php

namespace Tests\Unit\FormValidation;

use App\Models\Product;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const NAME = 'Testing Validation on Store';
    const CATEGORY = 1;
    const UTC = '000000000000';

    public function test_required_validation()
    {
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url);
        $response->assertStatus(422);
        $product = [
            'name'        => self::NAME,
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => self::UTC,
        ];
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);

    }

    public function test_required_name_validation()
    {
        $product = [
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => self::UTC,
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['name'] = self::NAME;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_required_category_validation()
    {
        $product = [
            'name'        => self::NAME,
            'category_id' => self::CATEGORY,
            'utc'         => self::UTC,
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['category'] = self::CATEGORY;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_required_utc_validation()
    {
        $product = [
            'name'        => self::NAME,
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['utc'] = self::UTC;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_min_length_name_validation()
    {
        $product = [
            'name'        => 'TT', // min is 3 characters
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => self::UTC,
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['name'] = self::NAME;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_max_length_name_validation()
    {
        $product = [
            'name'        => str_repeat('T', 256), // max is 255 characters
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => self::UTC,
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['name'] = self::NAME;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_unique_name_validation()
    {
        $name = Product::all()->random()->name;
        $product = [
            'name'        => $name,
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => self::UTC,
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['name'] = self::NAME;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_max_length_description_validation()
    {
        $product = [
            'name'        => self::NAME,
            'description' => str_repeat('T', 5001), // max is 5000 characters
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => self::UTC,
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['description'] = self::NAME;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_min_value_weight_validation()
    {
        $product = [
            'name'        => self::NAME,
            'weight'      => -1, // min is 0
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => self::UTC,
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['weight'] = 0;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_exists_category_validation()
    {
        $product = [
            'name'        => self::NAME,
            'category_id' => self::CATEGORY,
            'category'    => 999999,
            'utc'         => self::UTC,
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['category'] = self::CATEGORY;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_is_numeric_utc_validation()
    {
        $product = [
            'name'        => self::NAME,
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => str_repeat('A', 12),
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['utc'] = self::UTC;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_min_length_utc_validation()
    {
        $product = [
            'name'        => self::NAME,
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => str_repeat('0', 11), // min is 12 characters
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['utc'] = self::UTC;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_max_length_utc_validation()
    {
        $product = [
            'name'        => self::NAME,
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => str_repeat('0', 13), // max is 12 characters
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['utc'] = self::UTC;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_unique_utc_validation()
    {
        $utc = Product::all()->random()->utc;
        $product = [
            'name'        => self::NAME,
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => $utc,
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['utc'] = self::UTC;
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_is_numeric_ean_validation()
    {
        $product = [
            'name'        => self::NAME,
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => self::UTC,
            'ean'         => str_repeat('A', 13),
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['ean'] = str_repeat('0', 13);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_min_length_ean_validation()
    {
        $product = [
            'name'        => self::NAME,
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => self::UTC,
            'ean'         => str_repeat('0', 12), // min is 13 characters
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['ean'] = str_repeat('0', 13);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_max_length_ean_validation()
    {
        $product = [
            'name'        => self::NAME,
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => self::UTC,
            'ean'         => str_repeat('0', 14), // max is 13 characters
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['ean'] = str_repeat('0', 13);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }

    public function test_unique_ean_validation()
    {
        $ean = null;
        while (is_null($ean))
            $ean = Product::all()->random()->ean;
        $product = [
            'name'        => self::NAME,
            'category_id' => self::CATEGORY,
            'category'    => self::CATEGORY,
            'utc'         => self::UTC,
            'ean'         => $ean,
        ];
        $id = factory(Product::class)->create()->id;
        $url = route('products.update', $id);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(422);
        $product['ean'] = str_repeat('0', 13);
        $response = $this->actingAs($this->getUser('attendant'))->putJson($url, $product);
        $response->assertStatus(200);
        unset($product['category']);
        $this->assertDatabaseHas('products', $product);
    }
}
