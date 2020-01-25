<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

/**
 * Ticket Model
 *   Table:
 *     tickets
 *   Attributes:
 *     id:         required | integer | unique
 *     product_id: required | \App\Models\Product::id (integer)
 *     status_id:  required | \App\Models\TicketStatus::id (integer)
 *     type_id:    required | \App\Models\TicketType::id (integer)
 *     closed_at:  nullable | timestamp
 *     created_at: nullable | timestamp
 *     created_by: nullable | \App\Models\User::id (integer)
 *     updated_at: nullable | timestamp
 *     updated_by: nullable | \App\Models\User::id (integer)
 *   Relationships:
 *     product:   \App\Models\Product (BelongsTo)
 *     status:    \App\Models\TicketStatus (BelongsTo)
 *     type:      \App\Models\TicketType (BelongsTo)
 *     creator:   \App\Models\User (BelongsTo)
 *     editor:    \App\Models\User (BelongsTo)
 *     messages:  \App\Models\TicketMessages[] (HasMany)
 *
 * @mixin Eloquent
 */
class Ticket extends Model
{
    use Userstamps;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['created_by', 'created_at', 'closed_at', 'product_id', 'type_id', 'status_id'];

    /**
     * Attributes to be cast to native types
     *
     * @var array
     */
    protected $casts = [
        'closed_at' => 'datetime',
    ];

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
