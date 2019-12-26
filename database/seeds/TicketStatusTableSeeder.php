<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketStatusTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('ticket_status')->insert([
            ['name' => 'OPEN',   'description' => 'Aberto'],
            ['name' => 'CLOSED', 'description' => 'Fechado'],
        ]);
    }
}
