<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketStatusTableSeeder extends Seeder
{
    /**
     * Seed the database table
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_status')->insert([
            ['name' => 'ABERTO'],
            ['name' => 'FECHADO'],
        ]);
    }
}
