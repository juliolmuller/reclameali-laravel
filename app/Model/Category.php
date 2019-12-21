<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name'];
}
