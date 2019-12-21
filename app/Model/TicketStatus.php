<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketStatus extends Model
{
    use SoftDeletes;

    /**
     * Table associated with the model
     *
     * @var string
     */
    protected $table = 'ticket_status';
}
