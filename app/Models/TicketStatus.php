<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * Ticket Status Model
 *   Table:
 *     ticket_status
 *   Attributes:
 *     id:          required | integer | unique
 *     name:        required | string(1-30) | unique
 *     description: nullable | string(0-255)
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
class TicketStatus extends Model
{
    use SoftDeletes,
        Userstamps;

    /**
     * Table associated with the model
     *
     * @var string
     */
    protected $table = 'ticket_status';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * Number of status per page (on pagination)
     *
     * @var int
     */
    protected $perPage = 30;

    /**
     * Get the tickets associated with $this status
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'status_id')->orderByDesc('created_at');
    }
}
