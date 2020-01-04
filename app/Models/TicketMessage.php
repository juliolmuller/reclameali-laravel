<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    /**
     * Indicate the column name for 'created_at'
     *
     * @var string
     */
    const CREATED_AT = 'sent_at';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['body', 'ticket_id', 'sent_by', 'sent_at'];

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
