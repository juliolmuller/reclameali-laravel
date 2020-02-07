<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * Category Model
 *   Table:
 *     categories
 *   Attributes:
 *     id:         required | integer | unique
 *     name:       required | string(3-50) | unique
 *     created_at: nullable | timestamp
 *     created_by: nullable | \App\Models\User::id (integer)
 *     updated_at: nullable | timestamp
 *     updated_by: nullable | \App\Models\User::id (integer)
 *     deleted_at: nullable | timestamp
 *     deleted_by: nullable | \App\Models\User::id (integer)
 *   Relationships:
 *     creator:   \App\Models\User (BelongsTo)
 *     editor:    \App\Models\User (BelongsTo)
 *     destroyer: \App\Models\User (BelongsTo)
 *     products:  \App\Models\Product[] (HasMany)
 *
 * @mixin Eloquent
 */
class Category extends Model
{
    use SoftDeletes,
        Userstamps;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Number of categories per page (on pagination)
     *
     * @var int
     */
    protected $perPage = 30;

    /**
     * Relations to be eager loaded for every model
     *
     * @var array
     */
    protected $with = ['creator', 'editor', 'destroyer'];

    /**
     * Get the products associated with $this category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('name');
    }
}
