<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the products associated with $this category
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Model\Product>
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
