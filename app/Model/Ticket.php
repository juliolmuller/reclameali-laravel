<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['created_by', 'created_at', 'closed_at', 'product_id', 'type_id', 'status_id'];

    /**
     * Attributes to be cast to native types
     *
     * @var array
     */
    protected $casts = [
        'closed_at' => 'datetime',
    ];
}
