<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
