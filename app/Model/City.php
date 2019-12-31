<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

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
     * @return \App\Model\State
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
