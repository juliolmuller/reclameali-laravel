<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Access Role
 *
 * @package App\Models
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
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\User>
     */
    public function users()
    {
        return $this->hasMany(User::class)->orderBy('email');
    }
}
