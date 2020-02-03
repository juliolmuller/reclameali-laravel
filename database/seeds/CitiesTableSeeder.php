<?php

use App\Models\City;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
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
        $response = $client->request(City::IBGE_API_METHOD, City::IBGE_API_URL);
        $cities = json_decode($response->getBody());
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
