<?php

namespace Tests\Unit\FormValidation;

use App\Models\City;
use App\Models\State;
use App\Models\User;
use Tests\TestCase;

class StoreUserTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const FIRST_NAME = 'Josnei';
    const LAST_NAME = 'Silva';
    const CPF = '90094905053';
    const EMAIL = 'josnei.silva@email.com';
    const PHONE = '41985187730';
    const DATE_BIRTH = '1990-03-30';
    const STREET = 'Av. Valid Street Name';
    const NUMBER = '123';
    const COMPLEMENT = 'Apt. 123';
    const ZIP_CODE = '80123100';
    const PSWD = '!l0v3c1ick';

    public function test_required_validation()
    {
        $user = $this->getUser('manager');
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url);
        $response->assertStatus(422);
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_required_firstName_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['first_name'] = self::FIRST_NAME;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_required_lastName_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['last_name'] = self::LAST_NAME;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_required_cpf_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['cpf'] = self::CPF;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_required_email_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['email'] = self::EMAIL;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_required_dateOfBirth_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['date_of_birth'] = self::DATE_BIRTH;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_required_password_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['password'] = self::PSWD;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_required_passwordConfirmation_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'    => self::FIRST_NAME,
            'last_name'     => self::LAST_NAME,
            'cpf'           => self::CPF,
            'email'         => self::EMAIL,
            'date_of_birth' => self::DATE_BIRTH,
            'role'          => $this->getUser('manager')->role_id,
            'password'      => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['password_confirmation'] = self::PSWD;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_is_numeric_cpf_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => 'A1234567890',
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['cpf'] = self::CPF;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_is_numeric_phone_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'phone'                 => '4198518773A',
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['phone'] = self::PHONE;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_is_numeric_streetNumber_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'number'                => 'A',
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['number'] = self::NUMBER;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_is_numeric_zipCode_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'zip_code'              => '80123A00',
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['zip_code'] = self::ZIP_CODE;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_size_zipCode_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $newUser['zip_code'] = '801231000'; // size must be 8 length
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['zip_code'] = '8012310'; // size must be 8 length
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['zip_code'] = self::ZIP_CODE;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_min_length_firstName_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => '', // min is 1 character
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['first_name'] = self::FIRST_NAME;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_min_length_lastName_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => '', // min is 1 character
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['last_name'] = self::LAST_NAME;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_min_length_phone_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'phone'                 => '123456789', // min is 10 digits
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['phone'] = '1234567890';
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_min_length_password_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => 'PASSNOW', // min is 8 characters
            'password_confirmation' => 'PASSNOW', // min is 8 characters
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['password'] = self::PSWD;
        $newUser['password_confirmation'] = self::PSWD;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_min_value_dateOfBirth_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => now()->subYears(18)->addDay(),
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['date_of_birth'] = self::DATE_BIRTH;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_min_value_streetNumber_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'number'                => -1, // min is value 0
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['number'] = 0;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_max_length_firstName_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => str_repeat('T', 31), // max is 30 characters
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['first_name'] = self::FIRST_NAME;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_max_length_lastName_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => str_repeat('T', 151), // max is 150 characters
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['last_name'] = self::LAST_NAME;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_max_length_phone_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'phone'                 => '123456789000', // max is 11 digits
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['phone'] = '12345678900';
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_max_length_street_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'street'                => str_repeat('S', 256), // max is 255 characters
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['street'] = self::STREET;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_max_length_complement_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'complement'            => str_repeat('S', 21), // max is 20 characters
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['complement'] = self::COMPLEMENT;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_unique_cpf_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => User::get()->random()->cpf,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['cpf'] = self::CPF;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_unique_email_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => User::get()->random()->email,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['email'] = self::EMAIL;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_exists_state_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'state'                 => 0,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['state'] = State::get()->random()->id;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['state']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_exists_city_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'city'                  => 0,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['city'] = City::get()->random()->id;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['city']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_exists_role_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => 0,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['role'] = $this->getUser('manager')->role_id;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_is_valid_firstName_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => 'Josnei 22',
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['first_name'] = self::FIRST_NAME;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_is_valid_lastName_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => 'Silva 22',
            'cpf'                   => self::CPF,
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['last_name'] = self::LAST_NAME;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_is_valid_cpf_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => '90094905052',
            'email'                 => self::EMAIL,
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['cpf'] = self::CPF;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }

    public function test_is_valid_email_validation()
    {
        $user = $this->getUser('manager');
        $newUser = [
            'first_name'            => self::FIRST_NAME,
            'last_name'             => self::LAST_NAME,
            'cpf'                   => self::CPF,
            'email'                 => 'josnei.silva_email.com',
            'date_of_birth'         => self::DATE_BIRTH,
            'role'                  => $this->getUser('manager')->role_id,
            'password'              => self::PSWD,
            'password_confirmation' => self::PSWD,
        ];
        $url = route('users.store');
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(422);
        $newUser['email'] = self::EMAIL;
        $response = $this->actingAs($user)->postJson($url, $newUser);
        $response->assertStatus(201);
        $newUser['role_id'] = $newUser['role'];
        unset($newUser['role']);
        unset($newUser['password']);
        unset($newUser['password_confirmation']);
        $this->assertDatabaseHas('users', $newUser);
    }
}
