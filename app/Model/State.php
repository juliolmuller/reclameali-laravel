<?php

namespace App\Model;

use App\Model\City;
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
     * @return \Illuminate\Database\Eloquent\Collection<\App\Model\City>
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
