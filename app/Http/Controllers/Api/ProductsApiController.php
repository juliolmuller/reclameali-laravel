<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest as StoreRequest;
use App\Http\Requests\UpdateProductRequest as UpdateRequest;
use App\Http\Resources\Product as Resource;
use App\Models\Product;

class ProductsApiController extends Controller
{
    /**
     * Extract attributes from request and save them to the model
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \App\Models\Product $product
     * @return void
     */
    private function save($request, Product $product)
    {
        $product->description = $request->input('description');
        $product->category_id = $request->input('category');
        $product->weight = $request->input('weight');
        $product->name = $request->input('name');
        $product->utc = $request->input('utc');
        $product->ean = $request->input('ean');

        $product->save();
    }

    /**
     * Return JSON of all products
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        return Resource::collection(
            Product::withDefault()
                ->orderBy('name')
                ->paginate()
        );
    }

    /**
     * Return JSON of given product
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Product $product)
    {
        $product->loadDefault();

        return Resource::make($product);
    }

    /**
     * Persist new product
     *
     * @param \App\Http\Requests\StoreProductRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreRequest $request)
    {
        $product = new Product();

        $this->save($request, $product);

        $product->loadDefault();

        return Resource::make($product);
    }

    /**
     * Update existing product
     *
     * @param \App\Http\Requests\UpdateProductRequest $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $this->save($request, $product);

        $product->loadDefault();

        return Resource::make($product);
    }

    /**
     * Softdeletes given product
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->loadDefault();
        $product->delete();

        return Resource::make($product);
    }
}
