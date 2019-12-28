<?php

use App\Model\Category;
use App\Model\Product;
use Illuminate\Database\Seeder;

class CategoriesAndProductsTableSeeder extends Seeder
{
    public function run()
    {
        factory(Category::class, 20)->create()->each(function ($category) {
            $category->products()->saveMany(factory(Product::class, rand(5, 40))->make());
        });
    }
}
