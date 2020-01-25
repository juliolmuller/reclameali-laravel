<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * City Model
 *   Table:
 *     cities
 *   Attributes:
 *     id:         required | integer | unique
 *     name:       required | string(0-80)
 *     state_id:   required | \App\Models\State::id (integer)
 *     created_at: nullable | timestamp
 *     updated_at: nullable | timestamp
 *   Relationships:
 *     state: \App\Models\State (BelongsTo)
 *     users: \App\Models\User[] (HasMany)
 *
 * @mixin Eloquent
 */
class City extends Model
{
    /**
     * Public IBGE API for consulting Brazilian cities data
     * Documentation: https://servicodados.ibge.gov.br/api/docs/localidades
     *
     * @var string
     */
    public const IBGE_API_METHOD = 'GET';
    public const IBGE_API_URL = 'https://servicodados.ibge.gov.br/api/v1/localidades/municipios';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'state_id'];

    /**
     * Get the state associated with $this city
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the users associated with $this city
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class)->orderBy('email');
    }
}
