<?php

namespace Tests\Unit\Models;

use App\Model\Category;
use App\Model\Product;
use App\Model\Ticket;
use PDOException;
use Tests\TestCase;

class ProductTest extends TestCase
{
    private const TABLE_NAME = 'products';
    private const CLASS_NAME = Product::class;

    public function test_not_null_constraint_for_name_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $product = factory(self::CLASS_NAME)->make();
        $product->name = null;
        $product->save();
    }

    public function test_not_null_constraint_for_name_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $product = factory(self::CLASS_NAME)->create();
        $product->name = null;
        $product->save();
    }

    public function test_not_null_constraint_for_category_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $product = factory(self::CLASS_NAME)->make();
        $product->category_id = null;;
        $product->save();
    }

    public function test_not_null_constraint_for_category_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $product = factory(self::CLASS_NAME)->create();
        $product->category_id = null;
        $product->save();
    }

    public function test_not_null_constraint_for_utc_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $product = factory(self::CLASS_NAME)->make();
        $product->utc = null;
        $product->save();
    }

    public function test_not_null_constraint_for_utc_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $product = factory(self::CLASS_NAME)->create();
        $product->utc = null;
        $product->save();
    }

    public function test_category_relationship()
    {
        $samples = ceil(Product::count() / 10);
        for ($i = 0; $i < $samples; $i++) {
            $product = Product::all()->random();
            $fromProduct = $product->category;
            $fromCategory = Category::find($product->category_id);
            $this->assertEquals($fromProduct->id, $fromCategory->id);
        }
    }

    public function test_tickets_relationship()
    {
        $samples = ceil(Product::count() / 10);
        for ($i = 0; $i < $samples; $i++) {
            $product = Product::all()->random();
            $fromProduct = $product->tickets;
            $fromTicket = Ticket::where('product_id', $product->id)->orderByDesc('created_at')->get();
            for ($j = 0; $j < $fromProduct->count(); $j++)
                $this->assertEquals($fromProduct[$j]->id, $fromTicket[$j]->id);
        }
    }

    public function test_model_saving()
    {
        $before = Product::count();
        $product = factory(self::CLASS_NAME)->make();
        $status = $product->save();
        $id = $product->id;
        $name = $product->name;
        $after = Product::count();
        $this->assertTrue($status);
        $this->assertEquals(1, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'name'));
    }

    public function test_model_update()
    {
        $product = factory(self::CLASS_NAME)->create();
        $before = Product::count();
        $id = $product->id;
        $product->name = $name = 'Other name';
        $status = $product->save();
        $after = Product::count();
        $this->assertTrue($status);
        $this->assertEquals(0, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'name'));
    }

    public function test_model_softdeletion()
    {
        $product = factory(self::CLASS_NAME)->create();
        $beforeAll = Product::count();
        $before = Product::onlyTrashed()->count();
        $id = $product->id;
        $status = $product->delete();
        $afterAll = Product::count();
        $after = Product::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(1, $after - $before);
        $this->assertSoftDeleted(self::TABLE_NAME, compact('id'));
    }

    public function test_model_deletion()
    {
        $product = factory(self::CLASS_NAME)->create();
        $beforeAll = Product::count();
        $before = Product::onlyTrashed()->count();
        $id = $product->id;
        $status = $product->forceDelete();
        $afterAll = Product::count();
        $after = Product::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(0, $after - $before);
        $this->assertDeleted(self::TABLE_NAME, compact('id'));
    }
}
