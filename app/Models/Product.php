<?php

namespace App\Models;

use App\Models\Traits\DefaultRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * Product Model
 *
 * @mixin \Eloquent
 *
 * Database table:
 * @table products
 *
 * Database columns:
 * @property integer id                            required | unique
 * @property string name                           required | length: 3 to 255 | unique
 * @property string description                    nullable | length: 0 to 5000
 * @property float weight                          nullable | unsigned
 * @property integer category_id                   required | \App\Models\Category::id
 * @property string utc                            required | length: 12
 * @property string ean                            nullable | length: 13
 * @property \Illuminate\Support\Carbon created_at nullable
 * @property integer created_by                    nullable | \App\Models\User::id
 * @property \Illuminate\Support\Carbon updated_at nullable
 * @property integer updated_by                    nullable | \App\Models\User::id
 * @property \Illuminate\Support\Carbon deleted_at nullable
 * @property integer deleted_by                    nullable | \App\Models\User::id
 *
 * Database relations:
 * @property \App\Models\Category category         BelongsTo (many-to-one)
 * @property \App\Models\User creator              BelongsTo (many-to-one)
 * @property \App\Models\User editor               BelongsTo (many-to-one)
 * @property \App\Models\User destroyer            BelongsTo (many-to-one)
 * @property \App\Models\Ticket[] tickets          HasMany (one-to-many)
 */
class Product extends Model
{
    use DefaultRelations,
        SoftDeletes,
        Userstamps;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'weight', 'category_id', 'utc', 'ean'];

    /**
     * Number of products per page (on pagination)
     *
     * @var int
     */
    protected $perPage = 30;

    /**
     * Relations to be eager loaded on 'withDefault' and 'loadDefault' calls
     *
     * @var array
     */
    protected const RELATIONS = ['category', 'creator', 'editor', 'destroyer'];

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
