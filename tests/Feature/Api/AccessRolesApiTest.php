<?php

namespace Tests\Feature\Api;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class AccessRolesApiTest extends TestCase
{
    private function getUser()
    {
        return User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->get()->random();
    }

    public function test_roles_index()
    {
        $role = Role::orderBy('name')->first();
        $url = route('roles.index');
        $response = $this->actingAs($this->getUser())->getJson($url);
        $response->assertStatus(200);
        if ($role) {
            $response->assertJson([
                'data' => [
                    [
                        'id'          => $role->id,
                        'name'        => $role->name,
                        'description' => $role->description,
                    ],
                ],
            ]);
        }
    }

    public function test_roles_show()
    {
        $role = Role::all()->random();
        $url = route('roles.show', $role->id);
        $response = $this->actingAs($this->getUser())->getJson($url);
        $response->assertStatus(200);
        $response->assertJson([
            'id'          => $role->id,
            'name'        => $role->name,
            'description' => $role->description,
        ]);
    }

    public function test_roles_store()
    {
        $name = 'newrole';
        $url = route('roles.store');
        $response = $this->actingAs($this->getUser())->postJson($url, compact('name'));
        $response->assertStatus(201);
        $response->assertJson(compact('name'));
        $this->assertDatabaseHas('access_roles', compact('name'));
    }

    public function test_roles_update()
    {
        $role = new Role(['name' => 'newrole']);
        $role->save();
        $id = $role->id;
        $name = 'updaterole';
        $url = route('roles.update', $id);
        $response = $this->actingAs($this->getUser())->putJson($url, compact('name'));
        $response->assertStatus(200);
        $response->assertJson(compact('id', 'name'));
        $this->assertDatabaseHas('access_roles', compact('id', 'name'));
    }

    public function test_roles_destroy()
    {
        $role = new Role(['name' => 'DeleteRole']);
        $role->save();
        $id = $role->id;
        $url = route('roles.destroy', $id);
        $response = $this->actingAs($this->getUser())->deleteJson($url);
        $response->assertStatus(200);
        $this->assertDeleted('access_roles', compact('id'));
        $response->assertJson(compact('id'));
    }
}
