<?php

namespace Tests\Unit\Models;

use App\Model\User;
use PDOException;
use Tests\TestCase;

class UserTest extends TestCase
{
    private const TABLE_NAME = 'users';
    private const CLASS_NAME = User::class;

    public function test_not_null_constraint_for_firstName_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $user = factory(self::CLASS_NAME)->make();
        $user->first_name = null;
        $user->save();
    }

    public function test_not_null_constraint_for_firstName_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $user = factory(self::CLASS_NAME)->create();
        $user->first_name = null;
        $user->save();
    }

    public function test_not_null_constraint_for_lastName_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $user = factory(self::CLASS_NAME)->make();
        $user->last_name = null;
        $user->save();
    }

    public function test_not_null_constraint_for_lastName_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $user = factory(self::CLASS_NAME)->create();
        $user->last_name = null;
        $user->save();
    }

    public function test_not_null_constraint_for_cpf_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $user = factory(self::CLASS_NAME)->make();
        $user->cpf = null;
        $user->save();
    }

    public function test_not_null_constraint_for_cpf_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $user = factory(self::CLASS_NAME)->create();
        $user->cpf = null;
        $user->save();
    }

    public function test_not_null_constraint_for_email_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $user = factory(self::CLASS_NAME)->make();
        $user->email = null;
        $user->save();
    }

    public function test_not_null_constraint_for_email_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $user = factory(self::CLASS_NAME)->create();
        $user->email = null;
        $user->save();
    }

    public function test_not_null_constraint_for_password_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $user = factory(self::CLASS_NAME)->make();
        $user->password = null;
        $user->save();
    }

    public function test_not_null_constraint_for_password_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $user = factory(self::CLASS_NAME)->create();
        $user->password = null;
        $user->save();
    }

    public function test_not_null_constraint_for_role_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $user = factory(self::CLASS_NAME)->make();
        $user->role_id = null;;
        $user->save();
    }

    public function test_not_null_constraint_for_role_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $user = factory(self::CLASS_NAME)->create();
        $user->role_id = null;
        $user->save();
    }

    public function test_model_saving()
    {
        $before = User::count();
        $user = factory(self::CLASS_NAME)->make();
        $status = $user->save();
        $id = $user->id;
        $first_name = $user->first_name;
        $last_name = $user->last_name;
        $email = $user->email;
        $password = $user->password;
        $after = User::count();
        $this->assertTrue($status);
        $this->assertEquals(1, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'first_name', 'last_name', 'email', 'password'));
    }

    public function test_model_update()
    {
        $user = factory(self::CLASS_NAME)->create();
        $before = User::count();
        $id = $user->id;
        $user->first_name = $first_name = 'New Name';
        $user->last_name = $last_name = 'New Last Name';
        $user->email = $email = 'New Email';
        $user->password = $password = 'New Password';
        $status = $user->save();
        $after = User::count();
        $this->assertTrue($status);
        $this->assertEquals(0, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'first_name', 'last_name', 'email', 'password'));
    }

    public function test_model_softdeletion()
    {
        $user = factory(self::CLASS_NAME)->create();
        $beforeAll = User::count();
        $before = User::onlyTrashed()->count();
        $id = $user->id;
        $status = $user->delete();
        $afterAll = User::count();
        $after = User::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(1, $after - $before);
        $this->assertSoftDeleted(self::TABLE_NAME, compact('id'));
    }

    public function test_model_deletion()
    {
        $user = factory(self::CLASS_NAME)->create();
        $beforeAll = User::count();
        $before = User::onlyTrashed()->count();
        $id = $user->id;
        $status = $user->forceDelete();
        $afterAll = User::count();
        $after = User::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(0, $after - $before);
        $this->assertDeleted(self::TABLE_NAME, compact('id'));
    }
}
