<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name', 'category_id', 'utc'];
}
