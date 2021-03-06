<?php

use App\Models\TicketType as Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketTypesTableSeeder extends Seeder
{
    /**
     * Seed the database table
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_types')->insert([
            ['description' => 'Dúvida'],
            ['description' => 'Reclamação'],
            ['description' => 'Sugestão'],
            ['description' => 'Outro'],
        ]);

        $other = Type::where('description', 'Outro')->first();
        $other->id = 9999;
        $other->save();
    }
}
