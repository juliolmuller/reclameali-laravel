<?php

namespace Tests\Unit\FormValidation;

use App\Models\Role;
use Tests\TestCase;

class StoreRoleTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const NAME = 'Fake_Name';

    public function test_required_name_validation()
    {
        $role = [];
        $url = route('roles.store');
        $response = $this->postJson($url, $role);
        $response->assertStatus(422);
        $role['name'] = self::NAME;
        $response = $this->postJson($url, $role);
        $response->assertStatus(201);
        $this->assertDatabaseHas('access_roles', $role);
    }

    public function test_alpha_dash_name_validation()
    {
        $role = ['name' => 'Fake Name'];
        $url = route('roles.store');
        $response = $this->postJson($url, $role);
        $response->assertStatus(422);
        $role['name'] = self::NAME;
        $response = $this->postJson($url, $role);
        $response->assertStatus(201);
        $this->assertDatabaseHas('access_roles', $role);
    }

    public function test_min_length_name_validation()
    {
        $role = ['name' => '']; // min is 1 characters
        $url = route('roles.store');
        $response = $this->postJson($url, $role);
        $response->assertStatus(422);
        $role['name'] = self::NAME;
        $response = $this->postJson($url, $role);
        $response->assertStatus(201);
        $this->assertDatabaseHas('access_roles', $role);
    }

    public function test_max_length_name_validation()
    {
        $role = ['name' => str_repeat('T', 11)]; // max is 10 characters
        $url = route('roles.store');
        $response = $this->postJson($url, $role);
        $response->assertStatus(422);
        $role['name'] = self::NAME;
        $response = $this->postJson($url, $role);
        $response->assertStatus(201);
        $this->assertDatabaseHas('access_roles', $role);
    }

    public function test_unique_name_validation()
    {
        $role = ['name' => self::NAME];
        $model = new Role($role);
        $model->save();
        $url = route('roles.store');
        $response = $this->postJson($url, $role);
        $response->assertStatus(422);
        $role['name'] = self::NAME . '2';
        $response = $this->postJson($url, $role);
        $response->assertStatus(201);
        $this->assertDatabaseHas('access_roles', $role);
    }

    public function test_max_length_description_validation()
    {
        $role = [
            'name'        => self::NAME,
            'description' => str_repeat('T', 256), // max is 255 characters
        ];
        $url = route('roles.store');
        $response = $this->postJson($url, $role);
        $response->assertStatus(422);
        $role['description'] = str_repeat('T', 255);
        $response = $this->postJson($url, $role);
        $response->assertStatus(201);
        $this->assertDatabaseHas('access_roles', $role);
    }
}
