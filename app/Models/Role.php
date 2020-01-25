<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Role Model
 *   Table:
 *     access_roles
 *   Attributes:
 *     id:          required | integer | unique
 *     name:        required | string(1-10) | unique
 *     description: nullable | string(0-255)
 *     created_at:  nullable | timestamp
 *     updated_at:  nullable | timestamp
 *   Relationships:
 *     users: \App\Models\User[] (HasMany)
 *
 * @mixin Eloquent
 */
class Role extends Model
{
    /**
     * Table associated with the model
     *
     * @var string
     */
    protected $table = 'access_roles';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the users associated with $this role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class)->orderBy('email');
    }
}
