<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest as StoreRequest;
use App\Http\Requests\UpdateProductRequest as UpdateRequest;

class ProductController extends Controller
{
    /**
     * Extract attributes from request and save them to the model
     */
    private function save($request, Product $product)
    {
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->weight = $request->weight;
        $product->name = $request->name;
        $product->utc = $request->utc;
        $product->ean = $request->ean;
        $product->save();
    }

    /**
     * Return JSON of all products
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::with('category')->orderBy('name')->paginate(30);
    }

    /**
     * Return JSON of given product
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product->load('category');
    }

    /**
     * Save new product
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $product = new Product();
        $this->save($request, $product);
        return $product->load('category');
    }

    /**
     * Update existing product
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $this->save($request, $product);
        return $product->load('category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->load('category')->delete();
        return $product;
    }
}
