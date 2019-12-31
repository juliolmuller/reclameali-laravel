<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RolesAndUsersTableSeeder extends Seeder
{
    public function run()
    {
        // Generate records for customers
        $role = new Role([
            'name'        => 'customer',
            'description' => 'Cliente',
        ]);
        $role->save();
        $role->users()->saveMany(factory(User::class, 120)->make(['role_id' => $role->id]));

        // Generate records for attendants
        $role = new Role([
            'name'        => 'attendant',
            'description' => 'Atendente',
        ]);
        $role->save();
        $role->users()->saveMany(factory(User::class, 20)->make(['role_id' => $role->id]));

        // Generate records for managers
        $role = new Role([
            'name'        => 'manager',
            'description' => 'Gerente',
        ]);
        $role->save();
        $role->users()->saveMany(factory(User::class, 4)->make(['role_id' => $role->id]));

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
