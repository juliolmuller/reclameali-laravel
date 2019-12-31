<?php

namespace App\Models;

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
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\Ticket>
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'type_id')->orderByDesc('created_at');
    }
}
