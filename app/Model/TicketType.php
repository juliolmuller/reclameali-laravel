<?php

namespace App\Model;

use App\Model\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketType extends Model
{
    use SoftDeletes;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['description'];

    /**
     * Get the tickets associated with $this type
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Model\Ticket>
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'type_id');
    }
}
