<?php

namespace Tests\Unit\FormValidation;

use App\Models\Role;
use Tests\TestCase;

class UpdateRoleTest extends TestCase
{
    /**
     * Default required attributes to be used along the test
     */
    const NAME = 'Fake_Name';

    public function test_required_name_validation()
    {
        $model = new Role(['name' => 'FakeName']);
        $model->save();
        $role = ['id'   => $model->id];
        $url = route('roles.update', $role['id']);
        $response = $this->putJson($url, $role);
        $response->assertStatus(422);
        $role['name'] = self::NAME;
        $response = $this->putJson($url, $role);
        $response->assertStatus(200);
        $this->assertDatabaseHas('access_roles', $role);
    }

    public function test_alpha_dash_name_validation()
    {
        $model = new Role(['name' => 'FakeName']);
        $model->save();
        $role = [
            'id'   => $model->id,
            'name' => 'Fake Name',
        ];
        $url = route('roles.update', $role['id']);
        $response = $this->putJson($url, $role);
        $response->assertStatus(422);
        $role['name'] = self::NAME;
        $response = $this->putJson($url, $role);
        $response->assertStatus(200);
        $this->assertDatabaseHas('access_roles', $role);
    }

    public function test_min_length_name_validation()
    {
        $model = new Role(['name' => self::NAME]);
        $model->save();
        $role = [
            'id'   => $model->id,
            'name' => '', // min is 1 characters
        ];
        $url = route('roles.update', $role['id']);
        $response = $this->putJson($url, $role);
        $response->assertStatus(422);
        $role['name'] = self::NAME;
        $response = $this->putJson($url, $role);
        $response->assertStatus(200);
        $this->assertDatabaseHas('access_roles', $role);
    }

    public function test_max_length_name_validation()
    {
        $model = new Role(['name' => self::NAME]);
        $model->save();
        $role = [
            'id'   => $model->id,
            'name' => str_repeat('T', 11), // max is 10 characters
        ];
        $url = route('roles.update', $role['id']);
        $response = $this->putJson($url, $role);
        $response->assertStatus(422);
        $role['name'] = self::NAME;
        $response = $this->putJson($url, $role);
        $response->assertStatus(200);
        $this->assertDatabaseHas('access_roles', $role);
    }

    public function test_unique_name_validation()
    {
        $model = new Role(['name' => self::NAME]);
        $model->save();
        $role = [
            'id'   => $model->id,
            'name' => Role::all()->random()->name,
        ];
        $url = route('roles.update', $role['id']);
        $response = $this->putJson($url, $role);
        $response->assertStatus(422);
        $role['name'] = self::NAME . '2';
        $response = $this->putJson($url, $role);
        $response->assertStatus(200);
        $this->assertDatabaseHas('access_roles', $role);
    }

    public function test_max_length_description_validation()
    {
        $model = new Role(['name' => self::NAME]);
        $model->save();
        $role = [
            'id'   => $model->id,
            'name' => self::NAME,
            'description' => str_repeat('T', 256), // max is 255 characters
        ];
        $url = route('roles.update', $role['id']);
        $response = $this->putJson($url, $role);
        $response->assertStatus(422);
        $role['description'] = str_repeat('T', 255);
        $response = $this->putJson($url, $role);
        $response->assertStatus(200);
        $this->assertDatabaseHas('access_roles', $role);
    }
}
