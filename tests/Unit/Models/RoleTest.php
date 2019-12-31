<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PDOException;
use Tests\TestCase;

class RoleTest extends TestCase
{
    private const TABLE_NAME = 'access_roles';
    private const CLASS_NAME = Role::class;

    public function test_users_relationship()
    {
        $samples = Role::count();
        for ($i = 0; $i < $samples; $i++) {
            $role = Role::all()->random();
            $fromRole = $role->users;
            $fromUser = User::where('role_id', $role->id)->orderBy('email')->get();
            for ($j = 0; $j < $fromRole->count(); $j++)
                $this->assertEquals($fromRole[$j]->id, $fromUser[$j]->id);
        }
    }
}
