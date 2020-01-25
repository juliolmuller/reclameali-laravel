<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

/**
 * Ticket Message Model
 *   Table:
 *     ticket_messages
 *   Attributes:
 *     id:         required | integer | unique
 *     body:       required | string(1-255) | unique
 *     ticket_id:  required | \App\Models\Ticket::id (integer)
 *     sent_at:    nullable | timestamp
 *     sent_by:    nullable | \App\Models\User::id (integer)
 *     updated_at: nullable | timestamp
 *     updated_by: nullable | \App\Models\User::id (integer)
 *   Relationships:
 *     ticket:    \App\Models\Ticket (BelongsTo)
 *     sender:    \App\Models\User (BelongsTo)
 *     creator:   \App\Models\User (BelongsTo)
 *     editor:    \App\Models\User (BelongsTo)
 *
 * @mixin Eloquent
 */
class TicketMessage extends Model
{
    use Userstamps;

    /**
     * Indicate the column name for 'created_at' and 'created_by'
     *
     * @var string
     */
    const CREATED_AT = 'sent_at';
    const CREATED_BY = 'sent_by';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['body', 'ticket_id', 'sent_by', 'sent_at'];

    /**
     * Relationships to be touched when model is created/updated
     *
     * @var array
     */
    protected $touches = ['ticket'];

    /**
     * Get the ticket associated with $this message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the user associated with $this message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->creator();
    }
}
