<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

/**
 * Model Ticket Message
 *
 * @package App\Models
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
     * @return \App\Models\Ticket
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the user associated with $this message
     *
     * @return \App\Models\User
     */
    public function sentBy()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
