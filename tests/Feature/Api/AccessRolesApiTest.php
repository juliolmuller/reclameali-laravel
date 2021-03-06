<?php

namespace Tests\Feature\Api;

use App\Models\Role;
use Tests\TestCase;

class AccessRolesApiTest extends TestCase
{
    public function test_roles_index()
    {
        $role = Role::orderBy('name')->first();
        $url = route('api.roles.index');
        $response = $this->actingAs($this->getUser('admin'))->getJson($url);
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
        $url = route('api.roles.show', $role->id);
        $response = $this->actingAs($this->getUser('admin'))->getJson($url);
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
        $url = route('api.roles.store');
        $response = $this->actingAs($this->getUser('admin'))->postJson($url, compact('name'));
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
        $url = route('api.roles.update', $id);
        $response = $this->actingAs($this->getUser('admin'))->putJson($url, compact('name'));
        $response->assertStatus(200);
        $response->assertJson(compact('id', 'name'));
        $this->assertDatabaseHas('access_roles', compact('id', 'name'));
    }

    public function test_roles_destroy()
    {
        $role = new Role(['name' => 'DeleteRole']);
        $role->save();
        $id = $role->id;
        $url = route('api.roles.destroy', $id);
        $response = $this->actingAs($this->getUser('admin'))->deleteJson($url);
        $response->assertStatus(200);
        $this->assertDeleted('access_roles', compact('id'));
        $response->assertJson(compact('id'));
    }
}
