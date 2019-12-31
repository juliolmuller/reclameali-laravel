<?php

namespace Tests\Unit\Models;

use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PDOException;
use Tests\TestCase;

class StateTest extends TestCase
{
    private const TABLE_NAME = 'states';
    private const CLASS_NAME = State::class;

    public function test_cities_relationship()
    {
        $samples = ceil(State::count() / 10);
        for ($i = 0; $i < $samples; $i++) {
            $state = State::all()->random();
            $fromState = $state->cities;
            $fromCity = City::where('state_id', $state->id)->orderBy('name')->get();
            for ($j = 0; $j < $fromState->count(); $j++)
                $this->assertEquals($fromState[$j]->id, $fromCity[$j]->id);
        }
    }

    public function test_users_relationship()
    {
        $samples = ceil(State::count() / 10);
        for ($i = 0; $i < $samples; $i++) {
            $state = State::all()->random();
            $fromState = $state->users;
            $fromUser = User::whereHas('state', function (Builder $query) use ($state) {
                $query->where('cities.state_id', $state->id);
            })->orderBy('email')->get();
            for ($j = 0; $j < $fromState->count(); $j++)
                $this->assertEquals($fromState[$j]->id, $fromUser[$j]->id);
        }
    }
}
