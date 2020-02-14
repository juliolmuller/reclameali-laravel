<?php

use App\Models\City;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
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
        $cities = json_decode(
            $client->request(
                City::IBGE_API_METHOD,
                City::IBGE_API_URL
            )->getBody()
        );

        foreach ($cities as $city) {

            DB::table('cities')->insert([
                'id'         => $city->id,
                'name'       => $city->nome,
                'state_id'   => $city->microrregiao->mesorregiao->UF->id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
