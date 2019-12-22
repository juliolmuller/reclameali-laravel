<?php

namespace App\Model;

use App\Model\Role;
use App\Model\State;
use App\Model\Ticket;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use SoftDeletes,
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
     * Get the state associated with $this user
     *
     * @return \App\Model\State
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the tickets associated with $this user
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Model\Ticket>
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'created_by');
    }
}
