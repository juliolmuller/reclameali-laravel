<?php

namespace Tests\Unit\Models;

use App\Model\Category;
use PDOException;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    private const TABLE_NAME = 'categories';
    private const CLASS_NAME = Category::class;

    public function test_not_null_constraint_for_name_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $category = factory(self::CLASS_NAME)->make();
        $category->name = null;
        $category->save();
    }

    public function test_not_null_constraint_for_name_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $category = factory(self::CLASS_NAME)->create();
        $category->name = null;
        $category->save();
    }

    public function test_model_saving()
    {
        $before = Category::count();
        $category = factory(self::CLASS_NAME)->make();
        $status = $category->save();
        $id = $category->id;
        $name = $category->name;
        $after = Category::count();
        $this->assertTrue($status);
        $this->assertEquals(1, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'name'));
    }

    public function test_model_update()
    {
        $category = factory(self::CLASS_NAME)->create();
        $before = Category::count();
        $id = $category->id;
        $category->name = $name = 'Other name';
        $status = $category->save();
        $after = Category::count();
        $this->assertTrue($status);
        $this->assertEquals(0, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'name'));
    }

    public function test_model_softdeletion()
    {
        $category = factory(self::CLASS_NAME)->create();
        $beforeAll = Category::count();
        $before = Category::onlyTrashed()->count();
        $id = $category->id;
        $status = $category->delete();
        $afterAll = Category::count();
        $after = Category::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(1, $after - $before);
        $this->assertSoftDeleted(self::TABLE_NAME, compact('id'));
    }

    public function test_model_deletion()
    {
        $category = factory(self::CLASS_NAME)->create();
        $beforeAll = Category::count();
        $before = Category::onlyTrashed()->count();
        $id = $category->id;
        $status = $category->forceDelete();
        $afterAll = Category::count();
        $after = Category::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(0, $after - $before);
        $this->assertDeleted(self::TABLE_NAME, compact('id'));
    }
}
