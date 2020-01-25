<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * Product Model
 *   Table:
 *     products
 *   Attributes:
 *     id:          required | integer | unique
 *     name:        required | string(3-255) | unique
 *     category_id: required | \App\Models\Category::id (integer)
 *     utc:         required | string(12)
 *     description: nullable | string(0-5000)
 *     weight:      nullable | float(>0)
 *     ean:         nullable | string(13)
 *     created_at:  nullable | timestamp
 *     created_by:  nullable | \App\Models\User::id (integer)
 *     updated_at:  nullable | timestamp
 *     updated_by:  nullable | \App\Models\User::id (integer)
 *     deleted_at:  nullable | timestamp
 *     deleted_by:  nullable | \App\Models\User::id (integer)
 *   Relationships:
 *     category:  \App\Models\Category (BelongsTo)
 *     creator:   \App\Models\User (BelongsTo)
 *     editor:    \App\Models\User (BelongsTo)
 *     destroyer: \App\Models\User (BelongsTo)
 *     tickets:   \App\Models\Ticket[] (HasMany)
 *
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the tickets associated with $this product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class)->orderByDesc('created_at');
    }
}
