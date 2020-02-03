<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CategoriesAndProductsTableSeeder extends Seeder
{
    /**
     * Seed the database table
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 20)->create()->each(function ($category) {
            $category->products()->saveMany(factory(Product::class, rand(5, 40))->make());
        });
    }
}
