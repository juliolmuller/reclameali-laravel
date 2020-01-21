<?php

namespace Tests\Feature\Api;

use App\Models\State;
use Tests\TestCase;

class LocationApiTest extends TestCase
{
    public function test_states_index()
    {
        $url = route('states.index');
        $response = $this->getJson($url);
        $response->assertStatus(200);
    }

    public function test_cities_index()
    {
        $url = route('cities.index');
        $response = $this->getJson($url);
        $response->assertStatus(200);
    }

    public function test_cities_by_state_index()
    {
        State::all()->each(function ($state) {
            $url = route('cities.filter', $state->id);
            $response = $this->getJson($url);
            $response->assertStatus(200);
        });
    }
}
