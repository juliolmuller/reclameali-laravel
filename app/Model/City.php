<?php

namespace App\Model;

use App\Model\State;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'state_id'];

    /**
     * Get the state associated with $this city
     *
     * @return \App\Model\State
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
