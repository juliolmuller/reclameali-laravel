<?php

use App\Models\State;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
        $now = now();
        $client = new Client();
        $response = $client->request(State::IBGE_API_METHOD, State::IBGE_API_URL);
        $states = json_decode($response->getBody());
        foreach ($states as $state) {
            DB::table('states')->insert([
                'id'          => $state->id,
                'abreviation' => $state->sigla,
                'name'        => $state->nome,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
}
