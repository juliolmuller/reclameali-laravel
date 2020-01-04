<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
        return Product::orderBy('name')->paginate(30);
    }

    /**
     * Return JSON of given product
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Save new product
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $this->save($request, $product);
        return $product;
    }

    /**
     * Update existing product
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->save($request, $product);
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $product;
    }
}
