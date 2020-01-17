<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * Model Ticket Status
 *
 * @package App\Models
 * @mixin Eloquent
 */
class TicketStatus extends Model
{
    use SoftDeletes,
        Userstamps;

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
    protected $fillable = ['name', 'description'];

    /**
     * Get the tickets associated with $this status
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\Ticket>
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'status_id')->orderByDesc('created_at');
    }
}
