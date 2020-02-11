<?php

namespace App\Models;

use App\Models\Traits\DefaultRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * Ticket Type Model
 *   Table:
 *     ticket_types
 *   Attributes:
 *     id:          required | integer | unique
 *     description: required | string(0-255) | unique
 *     created_at:  nullable | timestamp
 *     created_by:  nullable | \App\Models\User::id (integer)
 *     updated_at:  nullable | timestamp
 *     updated_by:  nullable | \App\Models\User::id (integer)
 *     deleted_at:  nullable | timestamp
 *     deleted_by:  nullable | \App\Models\User::id (integer)
 *   Relationships:
 *     creator:   \App\Models\User (BelongsTo)
 *     editor:    \App\Models\User (BelongsTo)
 *     destroyer: \App\Models\User (BelongsTo)
 *     tickets:   \App\Models\Ticket[] (HasMany)
 *
 * @mixin Eloquent
 */
class TicketType extends Model
{
    use DefaultRelations,
        SoftDeletes,
        Userstamps;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['description'];

    /**
     * Number of types per page (on pagination)
     *
     * @var int
     */
    protected $perPage = 30;

    /**
     * Relations to be eager loaded on 'withDefault' and 'loadDefault' calls
     *
     * @var array
     */
    protected const RELATIONS = ['creator', 'editor', 'destroyer'];

    /**
     * Get the tickets associated with $this type
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'type_id')->orderByDesc('created_at');
    }
}
