<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest as StoreRequest;
use App\Http\Requests\UpdateCategoryRequest as UpdateRequest;
use App\Http\Resources\Category as Resource;
use App\Models\Category;

class CategoriesApiController extends Controller
{
    /**
     * Extract attributes from request and persist to the database
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \App\Models\Category $category
     * @return void
     */
    private function save($request, Category $category)
    {
        $category->name = $request->input('name');

        $category->save();
    }

    /**
     * Return JSON of all categories
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        return Resource::collection(
            Category::withDefault()
                ->orderBy('name')
                ->paginate()
        );
    }

    /**
     * Return JSON of given category
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Category $category)
    {
        $category->loadDefault();

        return Resource::make($category);
    }

    /**
     * Persist new category
     *
     * @param \App\Http\Requests\StoreCategoryRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreRequest $request)
    {
        $category = new Category();

        $this->save($request, $category);

        $category->loadDefault();

        return Resource::make($category);
    }

    /**
     * Update existing category
     *
     * @param \App\Http\Requests\UpdateCategoryRequest $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(UpdateRequest $request, Category $category)
    {
        $this->save($request, $category);

        $category->loadDefault();

        return Resource::make($category);
    }

    /**
     * Softdeletes given category
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->loadDefault();
        $category->delete();

        return Resource::make($category);
    }
}
