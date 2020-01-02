<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryFormRequest as FormRequest;
use App\Http\Requests\NewCategoryFormRequest as NewFormRequest;
use App\Http\Requests\UpdateCategoryFormRequest as UpdateFormRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Extract attributes from request and save them to the model
     */
    private function save(Request $request, Category $category)
    {
        $category->name = $request->name;
        $category->save();
    }

    /**
     * Return JSON of all categories
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::orderBy('name')->get();
    }

    /**
     * Return JSON of given category
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Save new category
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $this->save($request, $category);
        return $category;
    }

    /**
     * Update existing category
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->save($request, $category);
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $category;
    }
}
