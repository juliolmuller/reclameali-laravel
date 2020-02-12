<?php

namespace App\Models;

use App\Models\Traits\DefaultRelations;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

/**
 * Ticket Model
 *
 * @mixin \Eloquent
 *
 * Database table:
 * @table tickets
 *
 * Database columns:
 * @property integer id                            required | unique
 * @property integer product_id                   required | \App\Models\Product::id
 * @property integer status_id                    required | \App\Models\TicketStatus::id
 * @property integer type_id                      required | \App\Models\TicketType::id
 * @property \Illuminate\Support\Carbon closed_at  nullable
 * @property \Illuminate\Support\Carbon created_at nullable
 * @property integer created_by                    nullable | \App\Models\User::id
 * @property \Illuminate\Support\Carbon updated_at nullable
 * @property integer updated_by                    nullable | \App\Models\User::id
 *
 * Database relations:
 * @property \App\Models\Product product           BelongsTo (many-to-one)
 * @property \App\Models\TicketStatus status       BelongsTo (many-to-one)
 * @property \App\Models\TicketType type           BelongsTo (many-to-one)
 * @property \App\Models\User creator              BelongsTo (many-to-one)
 * @property \App\Models\User editor               BelongsTo (many-to-one)
 * @property \App\Models\TicketMessages[] messages HasMany (one-to-many)
 */
class Ticket extends Model
{
    use DefaultRelations,
        Userstamps;

    /**
     * Attributes to be cast to native types
     *
     * @var array
     */
    protected $casts = [
        'closed_at' => 'datetime',
    ];

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['product_id', 'type_id', 'status_id'];

    /**
     * Number of tickets per page (on pagination)
     *
     * @var int
     */
    protected $perPage = 30;

    /**
     * Relations to be eager loaded on 'withDefault' and 'loadDefault' calls
     *
     * @var array
     */
    protected const RELATIONS = ['product', 'status', 'type', 'creator', 'editor'];

    /**
     * Get the product associated with $this ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the status associated with $this ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(TicketStatus::class, 'status_id');
    }

    /**
     * Get the type associated with $this ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(TicketType::class, 'type_id');
    }

    /**
     * Get the messages associated with $this ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(TicketMessage::class)->orderBy('sent_at');
    }
}
