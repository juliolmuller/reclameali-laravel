<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessRolesTableSeeder extends Seeder
{
    /**
     * Seed the database table
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        DB::table('access_roles')->insert([
            [
                'name'        => 'customer',
                'description' => 'Cliente',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'attendant',
                'description' => 'Atendente',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'manager',
                'description' => 'Gerente',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'admin',
                'description' => 'Admin',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);
    }
}
