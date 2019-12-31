<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Znck\Eloquent\Traits\BelongsToThrough;

class User extends Authenticatable
{
    use BelongsToThrough,
        SoftDeletes,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'cpf', 'date_of_birth', 'email', 'password', 'role_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Attributes to be cast to native types
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the role associated with $this user
     *
     * @return \App\Model\Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get the city associated with $this user
     *
     * @return \App\Model\City
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the state associated with $this user
     *
     * @return \App\Model\State
     */
    public function state()
    {
        return $this->belongsToThrough(State::class, City::class);
    }

    /**
     * Get the tickets associated with $this user
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Model\Ticket>
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'created_by')->orderByDesc('created_at');
    }
}
