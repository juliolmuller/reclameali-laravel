<?php

namespace Tests\Unit\FormValidation;

use App\Models\City;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateUserTest extends TestCase
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

    private function getUser($user = 'manager')
    {
        return User::whereHas('role', function (Builder $query) use ($user) {
            $query->where('name', $user);
        })->get()->random();
    }

    private function createUser($modifiers = [])
    {
        $user = factory(User::class)->create($modifiers)->toArray();
        Arr::set($user, 'role', $user['role_id']);
        Arr::set($user, 'city', $user['city_id']);
        $this->unset($user,  'password', 'created_at', 'updated_at');;
        return $user;
    }

    private function unset(&$arr, ...$elements)
    {
        foreach ($elements as $el) {
            unset($arr[$el]);
        }
    }

    public function test_required_firstName_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $this->unset($user, 'first_name');
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['first_name'] = self::FIRST_NAME;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_required_lastName_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $this->unset($user, 'last_name');
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['last_name'] = self::LAST_NAME;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_required_cpf_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $this->unset($user, 'cpf');
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['cpf'] = self::CPF;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_required_email_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $this->unset($user, 'email');
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['email'] = self::EMAIL;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_required_dateOfBirth_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $this->unset($user, 'date_of_birth');
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['date_of_birth'] = self::DATE_BIRTH;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_required_oldPassword_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser(['password' => Hash::make(self::PSWD)]);
        $user['password'] = self::PSWD;
        $user['password_confirmation'] = self::PSWD;
        $url = route('users.update-password', $user['id']);
        $response = $this->actingAs($manager)->patchJson($url, $user);
        $response->assertStatus(422);
        $user['old_password'] = self::PSWD;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city', 'old_password', 'password', 'password_confirmation');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_required_password_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser(['password' => Hash::make(self::PSWD)]);
        $user['old_password'] = self::PSWD;
        $user['password_confirmation'] = self::PSWD;
        $url = route('users.update-password', $user['id']);
        $response = $this->actingAs($manager)->patchJson($url, $user);
        $response->assertStatus(422);
        $user['password'] = self::PSWD;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city', 'old_password', 'password', 'password_confirmation');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_required_passwordConfirmation_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser(['password' => Hash::make(self::PSWD)]);
        $user['old_password'] = self::PSWD;
        $user['password'] = self::PSWD;
        $url = route('users.update-password', $user['id']);
        $response = $this->actingAs($manager)->patchJson($url, $user);
        $response->assertStatus(422);
        $user['password_confirmation'] = self::PSWD;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city', 'old_password', 'password', 'password_confirmation');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_is_numeric_cpf_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['cpf'] = 'A1234567890';
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['cpf'] = self::CPF;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_is_numeric_phone_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['phone'] = '4198518773A';
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['phone'] = self::PHONE;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_is_numeric_streetNumber_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['number'] = 'A';
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['number'] = self::NUMBER;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_is_numeric_zipCode_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['zip_code'] = '80123A00';
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['zip_code'] = self::ZIP_CODE;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_size_zipCode_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['zip_code'] = '801231000'; // size must be 8 length
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['zip_code'] = self::ZIP_CODE;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_min_length_firstName_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['first_name'] = ''; // min is 1 character
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['first_name'] = self::FIRST_NAME;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_min_length_lastName_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['last_name'] = ''; // min is 1 character
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['last_name'] = self::LAST_NAME;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_min_length_phone_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['phone'] = '123456789'; // min is 10 digits
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['phone'] = self::PHONE;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_min_length_password_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser(['password' => Hash::make(self::PSWD)]);
        $user['old_password'] = self::PSWD;
        $user['password'] = $user['password_confirmation'] = '1234567'; // min is 8 characters
        $url = route('users.update-password', $user['id']);
        $response = $this->actingAs($manager)->patchJson($url, $user);
        $response->assertStatus(422);
        $user['password'] = $user['password_confirmation'] = self::PSWD;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city', 'old_password', 'password', 'password_confirmation');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_min_value_dateOfBirth_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['date_of_birth'] = now()->subYears(18)->addDay();
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['date_of_birth'] = self::DATE_BIRTH;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_min_value_streetNumber_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['number'] = -1; // min is value 0
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['number'] = self::NUMBER;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_max_length_firstName_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['first_name'] = str_repeat('T', 31); // max is 30 characters
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['first_name'] = self::FIRST_NAME;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_max_length_lastName_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['last_name'] = str_repeat('T', 151); // max is 150 characters
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['last_name'] = self::LAST_NAME;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_max_length_phone_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['phone'] = '123456789000'; // max is 11 digits
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['phone'] = self::PHONE;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_max_length_street_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['street'] = str_repeat('T', 256); // max is 255 characters
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['street'] = self::STREET;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_max_length_complement_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['complement'] = str_repeat('T', 21); // max is 20 characters
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['complement'] = self::COMPLEMENT;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_unique_cpf_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['cpf'] = User::where('id', '<>', $user['id'])->get()->random()->cpf;
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['cpf'] = self::CPF;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_unique_email_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['email'] = User::where('id', '<>', $user['id'])->get()->random()->email;
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['email'] = self::EMAIL;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_exists_state_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['state'] = 0;
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['state'] = State::get()->random()->id;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city', 'state');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_exists_city_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['city'] = 0;
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['city'] = City::get()->random()->id;
        $user['city_id'] = $user['city'];
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_exists_role_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['role'] = 0;
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['role'] = ROle::get()->random()->id;
        $user['role_id'] = $user['role'];
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_is_valid_firstName_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['first_name'] = 'Josnei 22';
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['first_name'] = self::FIRST_NAME;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_is_valid_lastName_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['last_name'] = 'Silva 22';
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['last_name'] = self::LAST_NAME;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_is_valid_cpf_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['cpf'] = '90094905052';
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['cpf'] = self::CPF;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_is_valid_email_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser();
        $user['email'] = 'josnei.silva_email.com';
        $url = route('users.update-data', $user['id']);
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(422);
        $user['email'] = self::EMAIL;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city');
        $this->assertDatabaseHas('users', $user);
    }

    public function test_is_valid_currentPassword_validation()
    {
        $manager = $this->getUser();
        $user = $this->createUser(['password' => Hash::make(self::PSWD)]);
        $user['old_password'] = self::PSWD . 'abc';
        $user['password'] = $user['password_confirmation'] = self::PSWD;
        $url = route('users.update-password', $user['id']);
        $response = $this->actingAs($manager)->patchJson($url, $user);
        $response->assertStatus(422);
        $user['old_password'] = self::PSWD;
        $response = $this->actingAs($manager)->putJson($url, $user);
        $response->assertStatus(200);
        $this->unset($user, 'role', 'city', 'old_password', 'password', 'password_confirmation');
        $this->assertDatabaseHas('users', $user);
    }
}
