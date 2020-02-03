<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the database table
     *
     * @return void
     */
    public function run()
    {
        $this->seedCustomers(120);

        $this->seedAttendants(20);

        $this->seedManagers(4);

        $this->seedAdmins(2);

        $this->seedDummy();
    }

    /**
     * Insert records for customers
     *
     * @param int $quantity
     * @return void
     */
    private function seedCustomers(int $quantity)
    {
        Role::where('name', '=', 'customer')
            ->first()
            ->users()
            ->saveMany(factory(User::class, $quantity)->make());
    }

    /**
     * Insert records for attendants
     *
     * @param int $quantity
     * @return void
     */
    private function seedAttendants(int $quantity)
    {
        Role::where('name', '=', 'attendant')
            ->first()
            ->users()
            ->saveMany(factory(User::class, $quantity)->make());
    }

    /**
     * Insert records for managers
     *
     * @param int $quantity
     * @return void
     */
    private function seedManagers(int $quantity)
    {
        Role::where('name', '=', 'manager')
            ->first()
            ->users()
            ->saveMany(factory(User::class, $quantity)->make());
    }

    /**
     * Insert records for admins
     *
     * @param int $quantity
     * @return void
     */
    private function seedAdmins(int $quantity)
    {
        Role::where('name', '=', 'admin')
            ->first()
            ->users()
            ->saveMany(factory(User::class, $quantity)->make());
    }

    /**
     * Insert records for visitors of the portfolio
     *
     * @return void
     */
    private function seedDummy()
    {
        $roles = Role::all();

        $createVisitor = function (User $guest, $i) use ($roles) {
            $guest->last_name = $roles[$i]->description;
            $guest->email = Str::lower("{$guest->first_name}.{$guest->last_name}@email.com");
            $guest->role_id = $roles[$i]->id;
            $guest->save();
        };

        factory(User::class, count($roles))
            ->make(['first_name' => 'Visitante', 'password' => Hash::make('123456789')])
            ->each($createVisitor);
    }
}
