<?php

namespace App\Models;

use App\Models\Traits\DefaultRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * Ticket Status Model
 *
 * @mixin \Eloquent
 *
 * Database table:
 * @table ticket_status
 *
 * Database columns:
 * @property integer id                            required | unique
 * @property string name                           required | length: 1 to 30 | unique
 * @property string description                    nullable | length: 0 to 255
 * @property \Illuminate\Support\Carbon created_at nullable
 * @property integer created_by                    nullable | \App\Models\User::id
 * @property \Illuminate\Support\Carbon updated_at nullable
 * @property integer updated_by                    nullable | \App\Models\User::id
 * @property \Illuminate\Support\Carbon deleted_at nullable
 * @property integer deleted_by                    nullable | \App\Models\User::id
 *
 * Database relations:
 * @property \App\Models\User creator              BelongsTo (many-to-one)
 * @property \App\Models\User editor               BelongsTo (many-to-one)
 * @property \App\Models\User destroyer            BelongsTo (many-to-one)
 * @property \App\Models\Ticket[] tickets          HasMany (one-to-many)
 */
class TicketStatus extends Model
{
    use DefaultRelations,
        SoftDeletes,
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
     * Relations to be eager loaded on 'withDefault' and 'loadDefault' calls
     *
     * @var array
     */
    protected const RELATIONS = ['creator', 'editor', 'destroyer'];

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
