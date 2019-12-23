<?php

namespace App\Model;

use App\Model\City;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'abreviation'];

    /**
     * Get the cities associated with $this state
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Model\City>
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
