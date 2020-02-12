<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * City Model
 *
 * @mixin \Eloquent
 *
 * Database table:
 * @table cities
 *
 * Database columns:
 * @property integer id                            required | unique
 * @property string name                           required | length: 0 to 80
 * @property integer state_id                      required | \App\Models\State::id
 * @property \Illuminate\Support\Carbon created_at nullable
 * @property \Illuminate\Support\Carbon updated_at nullable
 *
 * Database relations:
 * @property \App\Models\State state               BelongsTo (many-to-one)
 * @property \App\Models\User[] users              HasMany (one-to-many)
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
     * Serializable attributes
     *
     * @var array
     */
    protected $visible = ['id', 'name'];

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
