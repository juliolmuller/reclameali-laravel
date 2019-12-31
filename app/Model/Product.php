<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name', 'category_id', 'utc'];

    /**
     * Get the category associated with $this product
     *
     * @return \App\Model\Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the tickets associated with $this product
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Model\Ticket>
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
