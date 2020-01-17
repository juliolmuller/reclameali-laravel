<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * Model Product
 *
 * @package App\Models
 * @mixin Eloquent
 */
class Product extends Model
{
    use SoftDeletes,
        Userstamps;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name', 'category_id', 'utc'];

    /**
     * Get the category associated with $this product
     *
     * @return \App\Models\Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the tickets associated with $this product
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\Ticket>
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class)->orderByDesc('created_at');
    }
}
