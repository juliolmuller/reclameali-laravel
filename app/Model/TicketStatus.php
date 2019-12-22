<?php

namespace App\Model;

use App\Model\Ticket;
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

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the tickets associated with $this status
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Model\Ticket>
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'status_id');
    }
}
