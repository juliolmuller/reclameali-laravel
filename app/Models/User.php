<?php

namespace App\Models;

use App\Models\Traits\DefaultRelations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Wildside\Userstamps\Userstamps;
use Znck\Eloquent\Traits\BelongsToThrough;

/**
 * User Model
 *   Table:
 *     users
 *   Attributes:
 *     id:             required | integer | unique
 *     first_name:     required | string(1-30)
 *     last_name:      required | string(1-150)
 *     cpf:            required | string(11)
 *     email:          required | string(1-255)
 *     date_of_birth:  required | date
 *     password:       required | string(60)
 *     role_id:        required | \App\Models\Role::id (integer)
 *     phone:          nullable | string(0-16)
 *     remember_token: nullable | string(100)
 *     strett:         nullable | string(0-255)
 *     number:         nullable | integer
 *     complement:     nullable | string(0-20)
 *     zip_code:       nullable | string(8)
 *     city_id:        nullable | \App\Models\City::id (integer)
 *     created_at:     nullable | timestamp
 *     created_by:     nullable | \App\Models\User::id (integer)
 *     updated_at:     nullable | timestamp
 *     updated_by:     nullable | \App\Models\User::id (integer)
 *     deleted_at:     nullable | timestamp
 *     deleted_by:     nullable | \App\Models\User::id (integer)
 *   Relationships:
 *     role:      \App\Models\Role (BelongsTo)
 *     city:      \App\Models\City (BelongsTo)
 *     state:     \App\Models\State (BelongsToThrough)
 *     creator:   \App\Models\User (BelongsTo)
 *     editor:    \App\Models\User (BelongsTo)
 *     destroyer: \App\Models\User (BelongsTo)
 *     tickets:   \App\Models\Ticket[] (HasMany)
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use BelongsToThrough,
        DefaultRelations,
        Notifiable,
        SoftDeletes,
        Userstamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'cpf', 'date_of_birth', 'email', 'phone', 'password', 'role_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Number of users per page (on pagination)
     *
     * @var int
     */
    protected $perPage = 30;

    /**
     * Relations to be eager loaded on 'withDefault' and 'loadDefault' calls
     *
     * @var array
     */
    protected const RELATIONS = ['role', 'creator', 'editor', 'destroyer'];

    /**
     * Get the role associated with $this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get the city associated with $this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the state associated with $this user
     *
     * @return \Znck\Eloquent\Relations\BelongsToThrough
     */
    public function state()
    {
        return $this->belongsToThrough(State::class, City::class);
    }

    /**
     * Get the tickets associated with $this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'created_by')->orderByDesc('created_at');
    }
}
