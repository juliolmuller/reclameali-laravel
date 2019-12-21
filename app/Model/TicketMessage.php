<?php

namespace App\Model;

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
}
