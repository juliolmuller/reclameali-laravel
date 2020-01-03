<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     * Get the cities associated with $this state
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\City>
     */
    public function cities()
    {
        return $this->hasMany(City::class)->orderBy('name');
    }

    /**
     * Get the users associated with $this state
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\User>
     */
    public function users()
    {
        return $this->hasManyThrough(User::class, City::class)->orderBy('email');
    }
}