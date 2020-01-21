<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Support\Collection;

class LocationApiController extends Controller
{
    /**
     * Responds with a JSON of all states
     *
     * @return Collection<State>
     */
    public function states()
    {
        return State::orderBy('abreviation')->get();
    }

    /**
     * Responds with a JSON of all cities
     *
     * @return Collection<City>
     */
    public function cities()
    {
        return City::orderBy('name')->get();
    }

    /**
     * Responds with a JSON of all cities in a given state
     *
     * @param State $state
     * @return Collection<City>
     */
    public function citiesByState(State $state)
    {
        return $state->cities()->get();
    }
}
