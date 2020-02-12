<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * State Model
 *
 * @mixin \Eloquent
 *
 * Database table:
 * @table states
 *
 * Database columns:
 * @property integer id                            required | unique
 * @property string name                           required | length: 0 to 19
 * @property string abreviation                    required | length: 2
 * @property \Illuminate\Support\Carbon created_at nullable
 * @property \Illuminate\Support\Carbon updated_at nullable
 *
 * Database relations:
 * @property \App\Models\City[] cities             HasMany (one-to-many)
 * @property \App\Models\User[] users              HasManyThrough (one-to-many)
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
