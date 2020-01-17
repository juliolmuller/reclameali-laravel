<?php

namespace Tests\Feature\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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

    private function getUser($user = 'manager')
    {
        return User::whereHas('role', function ($query) use ($user) {
            $query->where('name', $user);
        })->get()->random();
    }

    public function test_users_index()
    {
        $user = User::whereHas('role', fn(Builder $query) => $query->where('name', '<>', 'customer'))
            ->with(['city.state', 'role'])
            ->orderBy('first_name')
            ->first();
        $url = route('users.index');
        $response = $this->actingAs($this->getUser())->getJson($url);
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
        $response = $this->actingAs($this->getUser())->getJson($url);
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
        $user = $this->getUser();
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

//    public function test_users_update()
//    {
//        $user = $this->getUser();
//        $user = factory(User::class)->create(['status_id' => self::OPEN, 'created_by' => $user->id]);
//        $message = 'Testing new message';
//        $url = route('users.update', $user->id);
//        $response = $this->actingAs($user)->putJson($url, compact('message'));
//        $response->assertStatus(200);
//        $response->assertJson([
//            'id' => $user->id,
//            'messages' => [
//                [
//                    'body'    => $message,
//                    'sent_by' => $user->id,
//                ],
//            ],
//        ]);
//        $this->assertDatabaseHas('user_messages', [
//            'user_id' => $user->id,
//            'body'      => $message,
//            'sent_by'   => $user->id,
//        ]);
//    }
//
//    public function test_users_update_for_customer()
//    {
//        do {
//            $user = $this->getUser('customer');
//        } while (!$user->users->count());
//        $message = 'Testing new message';
//        $user = User::where('created_by', '<>', $user->id)->get()->random();
//        $url = route('users.update', $user->id);
//        $response = $this->actingAs($user)->putJson($url, compact('message'));
//        $response->assertStatus(403);
//        $user = $user->users[0];
//        $url = route('users.update', $user->id);
//        $response = $this->actingAs($user)->putJson($url, compact('message'));
//        $response->assertStatus(200);
//        $this->assertDatabaseHas('user_messages', [
//            'user_id' => $user->id,
//            'body'      => $message,
//            'sent_by'   => $user->id,
//        ]);
//    }
//
//    public function test_users_destroy()
//    {
//        $user = factory(User::class)->create();
//        $user = $this->getUser('attendant');
//        $url = route('users.close', $user->id);
//        $response = $this->actingAs($user)->patchJson($url, []);
//        $response->assertStatus(200);
//        $response->assertJson([
//            'product_id' => $user->product_id,
//            'status_id'  => self::CLOSED,
//            'type_id'    => $user->type_id,
//            'created_by' => $user->created_by,
//        ]);
//    }
}
