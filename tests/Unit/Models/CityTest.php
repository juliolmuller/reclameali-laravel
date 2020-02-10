<?php

namespace Tests\Unit\Models;

use App\Models\City;
use App\Models\State;
use App\Models\User;
use Tests\TestCase;

class CityTest extends TestCase
{
    private const TABLE_NAME = 'cities';
    private const CLASS_NAME = City::class;

    public function test_state_relationship()
    {
        $samples = ceil(City::count() / 100);
        for ($i = 0; $i < $samples; $i++) {
            $city = City::all()->random();
            $fromCity = $city->state;
            $fromState = State::find($city->state_id);
            $this->assertEquals($fromCity->id, $fromState->id);
        }
    }

    public function test_users_relationship()
    {
        $samples = ceil(City::count() / 100);
        for ($i = 0; $i < $samples; $i++) {
            $city = City::all()->random();
            $fromCity = $city->users;
            $fromUser = User::where('city_id', $city->id)->get();
            for ($j = 0; $j < $fromCity->count(); $j++)
                $this->assertEquals($fromCity[$j]->id, $fromUser[$j]->id);
        }
    }
}
