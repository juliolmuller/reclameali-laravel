<?php

namespace App\Model;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name', 'abreviation'];

    /**
     * Get the users associated with $this state
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Model\User>
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
