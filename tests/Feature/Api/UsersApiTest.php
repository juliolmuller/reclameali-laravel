<?php

namespace Tests\Feature\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsersApiTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const FIRST_NAME = 'Josnei';
    const LAST_NAME = 'Silva';
    const CPF = '90094905053';
    const EMAIL = 'josnei.silva@email.com';
    const DATE_BIRTH = '1990-03-30';
    const PSWD = '!l0v3c1ick';

    public function test_users_index()
    {
        $user = User::whereHas('role', fn(Builder $query) => $query->where('name', '<>', 'customer'))
            ->with(['city.state', 'role'])
            ->orderBy('first_name')
            ->first();
        $url = route('users.index');
        $response = $this->actingAs($this->getUser('manager'))->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                [
                    'id'            => $user->id,
                    'first_name'    => $user->first_name,
                    'last_name'     => $user->last_name,
                    'cpf'           => $user->cpf,
                    'email'         => $user->email,
                    'date_of_birth' => $user->date_of_birth,
                    'street'        => $user->street,
                    'city_id'       => $user->city_id,
                    'role_id'       => $user->role_id,
                ],
            ],
        ]);
    }

    public function test_users_show()
    {
        $user = User::all()->random();
        $url = route('users.show', $user->id);
        $response = $this->actingAs($this->getUser('manager'))->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'            => $user->id,
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'cpf'           => $user->cpf,
            'email'         => $user->email,
            'date_of_birth' => $user->date_of_birth,
            'street'        => $user->street,
            'city_id'       => $user->city_id,
            'role_id'       => $user->role_id,
        ]);
    }

    public function test_users_show_for_customer()
    {
        $user = $this->getUser('customer');
        $url = route('users.show', $user->id);
        $response = $this->actingAs($user)->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'            => $user->id,
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'cpf'           => $user->cpf,
            'email'         => $user->email,
            'date_of_birth' => $user->date_of_birth,
            'street'        => $user->street,
            'city_id'       => $user->city_id,
            'role_id'       => Role::where('name', 'customer')->first()->id,
        ]);
        $otherUser = User::all()->random();
        $url = route('users.show', $otherUser->id);
        $response = $this->actingAs($user)->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'            => $user->id,
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'cpf'           => $user->cpf,
            'email'         => $user->email,
            'date_of_birth' => $user->date_of_birth,
            'street'        => $user->street,
            'city_id'       => $user->city_id,
            'role_id'       => Role::where('name', 'customer')->first()->id,
        ]);
    }

    public function test_users_store()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => Role::where('name', '<>', 'customer')->get()->random()->id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
        $response->assertJson($newUser);
    }

    public function test_users_updateData()
    {
        $user = $this->getUser('manager');
        $savedUser = factory(User::class)->create([
            'role_id' => Role::where('name', '<>', 'customer')->get()->random()->id,
        ]);
        $userData = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => Role::where('name', '<>', 'customer')->get()->random()->id,
        ];
        $url = route('users.update-data', $savedUser->id);
        $response = $this->actingAs($user)->putJson($url, $userData);
        $response->assertStatus(200);
        $userData['role_id'] = $userData['role'];
        unset($userData['role']);
        $this->assertDatabaseHas('users', $userData);
        $response->assertJson($userData);
    }

    public function test_users_updateData_for_customer()
    {
        $user = factory(User::class)->create([
            'role_id' => Role::where('name', 'customer')->first()->id,
        ]);
        do {
            $otherUserId = User::all()->random();
        } while ($otherUserId === $user->id);
        $userData = [
            'id'            => $user->id,
            'first_name'    => self::FIRST_NAME,
            'last_name'     => self::LAST_NAME,
            'cpf'           => self::CPF,
            'email'         => self::EMAIL,
            'date_of_birth' => self::DATE_BIRTH,
        ];
        $url = route('users.update-data', $otherUserId);
        $response = $this->actingAs($user)->putJson($url, $userData);
        $response->assertStatus(200);
        $response->assertJson($userData);
        $this->assertDatabaseHas('users', $userData);
        $url = route('users.update-data', $user->id);
        $response = $this->actingAs($user)->putJson($url, $userData);
        $response->assertStatus(200);
        $response->assertJson($userData);
        $this->assertDatabaseHas('users', $userData);
    }

    public function test_users_updatePassword()
    {
        $user = $this->getUser('manager');
        $savedUser = factory(User::class)->create([
            'password' => Hash::make(self::PSWD),
            'role_id'  => Role::where('name', '<>', 'customer')->get()->random()->id,
        ]);
        $userData = [
            'old_password'          => self::PSWD,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.update-data', $savedUser->id);
        $response = $this->actingAs($user)->patchJson($url, $userData);
        $response->assertStatus(200);
        $response->assertJson(['id' => $savedUser->id]);
    }

    public function test_users_updatePassword_for_customer()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make(self::PSWD),
            'role_id'  => Role::where('name', 'customer')->first()->id,
        ]);
        do {
            $otherUserId = User::all()->random();
        } while ($otherUserId->id === $user->id);
        $userData = [
            'old_password'          => self::PSWD,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.update-data', $otherUserId);
        $response = $this->actingAs($user)->patchJson($url, $userData);
        $response->assertStatus(422);
        $url = route('users.update-data', $user->id);
        $response = $this->actingAs($user)->patchJson($url, $userData);
        $response->assertStatus(200);
        $response->assertJson(['id' => $user->id]);
    }

    public function test_users_destroy()
    {
        $user = $this->getUser('manager');
        $savedUser = factory(User::class)->create([
            'role_id'  => Role::where('name', '<>', 'customer')->get()->random()->id,
        ]);
        $url = route('users.destroy', $savedUser->id);
        $response = $this->actingAs($user)->deleteJson($url);
        $response->assertStatus(200);
        $response->assertJson(['id' => $savedUser->id]);
        $this->assertSoftDeleted('users', ['id' => $savedUser->id]);
    }
}
