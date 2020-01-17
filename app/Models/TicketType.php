<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * Model Ticket Type
 *
 * @package App\Models
 * @mixin Eloquent
 */
class TicketType extends Model
{
    use SoftDeletes,
        Userstamps;

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
