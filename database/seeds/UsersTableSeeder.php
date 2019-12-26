<?php

use App\Model\Role;
use App\Model\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Generate records for customers
        $role = new Role([
            'name'        => 'customer',
            'description' => 'Cliente',
        ]);
        $role->save();
        factory(User::class, 120)->create(['role_id' => $role->id]);

        // Generate records for attendants
        $role = new Role([
            'name'        => 'attendant',
            'description' => 'Atendente',
        ]);
        $role->save();
        factory(User::class, 20)->create(['role_id' => $role->id]);

        // Generate records for managers
        $role = new Role([
            'name'        => 'manager',
            'description' => 'Gerente',
        ]);
        $role->save();
        factory(User::class, 4)->create(['role_id' => $role->id]);

        // Generate records for visitors access
        $roles = Role::all();
        factory(User::class, count($roles))->make([
            'first_name' => 'Visitante',
            'password'   => Hash::make('123456789'),
        ])->each(function ($guest, $i) use ($roles) {
            $guest->last_name = $roles[$i]->description;
            $guest->email = Str::lower("{$guest->first_name}.{$guest->last_name}@email.com");
            $guest->role_id = $roles[$i]->id;
            $guest->save();
        });
    }
}
