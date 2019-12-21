<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name', 'abreviation'];
}
