<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * State Model
 *   Table:
 *     states
 *   Attributes:
 *     id:          required | integer | unique
 *     name:        required | string(0-19)
 *     abreviation: required | string(2)
 *     created_at:  nullable | timestamp
 *     updated_at:  nullable | timestamp
 *   Relationships:
 *     cities: \App\Models\City[] (HasMany)
 *     users:  \App\Models\User[] (HasManyThrough)
 *
 * @mixin Eloquent
 */
class State extends Model
{
    /**
     * Public IBGE API for consulting Brazilian states data
     * Documentation: https://servicodados.ibge.gov.br/api/docs/localidades
     *
     * @var string
     */
    public const IBGE_API_METHOD = 'GET';
    public const IBGE_API_URL = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'abreviation'];

    /**
     * Serializable attributes
     *
     * @var array
     */
    protected $visible = ['id', 'name', 'abreviation'];

    /**
     * Get the cities associated with $this state
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class)->orderBy('name');
    }

    /**
     * Get the users associated with $this state
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function users()
    {
        return $this->hasManyThrough(User::class, City::class)->orderBy('email');
    }
}
