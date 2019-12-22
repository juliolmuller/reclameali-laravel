<?php

namespace App\Model;

use App\Model\Ticket;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketMessage extends Model
{
    use SoftDeletes;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['message_body', 'ticket_id', 'created_by', 'created_at'];

    /**
     * Get the ticket associated with $this message
     *
     * @return \App\Model\Ticket
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the user associated with $this message
     *
     * @return \App\Model\User
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
