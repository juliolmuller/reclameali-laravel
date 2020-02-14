<?php

use App\Models\State;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    /**
     * Seed the database table
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        $client = new Client();
        $states = json_decode(
            $client->request(
                State::IBGE_API_METHOD,
                State::IBGE_API_URL
            )->getBody()
        );

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
