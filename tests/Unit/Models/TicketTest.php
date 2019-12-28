<?php

namespace Tests\Unit\Models;

use App\Model\Product;
use App\Model\Ticket;
use App\Model\TicketStatus as Status;
use App\Model\TicketType as Type;
use App\Model\User;
use PDOException;
use Tests\TestCase;

class TicketTest extends TestCase
{
    private const TABLE_NAME = 'tickets';
    private const CLASS_NAME = Ticket::class;

    public function test_not_null_constraint_for_createdBy_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $ticket = factory(self::CLASS_NAME)->make();
        $ticket->created_by = null;
        $ticket->save();
    }

    public function test_not_null_constraint_for_createdBy_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $ticket = factory(self::CLASS_NAME)->create();
        $ticket->created_by = null;
        $ticket->save();
    }

    public function test_not_null_constraint_for_product_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $ticket = factory(self::CLASS_NAME)->make();
        $ticket->product_id = null;
        $ticket->save();
    }

    public function test_not_null_constraint_for_product_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $ticket = factory(self::CLASS_NAME)->create();
        $ticket->product_id = null;
        $ticket->save();
    }

    public function test_not_null_constraint_for_type_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $ticket = factory(self::CLASS_NAME)->make();
        $ticket->type_id = null;
        $ticket->save();
    }

    public function test_not_null_constraint_for_type_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $ticket = factory(self::CLASS_NAME)->create();
        $ticket->type_id = null;
        $ticket->save();
    }

    public function test_not_null_constraint_for_status_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $ticket = factory(self::CLASS_NAME)->make();
        $ticket->status_id = null;
        $ticket->save();
    }

    public function test_not_null_constraint_for_status_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $ticket = factory(self::CLASS_NAME)->create();
        $ticket->status_id = null;
        $ticket->save();
    }

    public function test_model_saving()
    {
        $before = Ticket::count();
        $ticket = factory(self::CLASS_NAME)->make();
        $status = $ticket->save();
        $id = $ticket->id;
        $created_by = $ticket->created_by;
        $product_id = $ticket->product_id;
        $type_id = $ticket->type_id;
        $status_id = $ticket->status_id;
        $after = Ticket::count();
        $this->assertTrue($status);
        $this->assertEquals(1, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'created_by', 'product_id', 'type_id', 'status_id'));
    }

    public function test_model_update()
    {
        $ticket = factory(self::CLASS_NAME)->create();
        $before = Ticket::count();
        $id = $ticket->id;
        $ticket->created_by = $created_by = User::all()->random()->id;
        $ticket->product_id = $product_id = Product::all()->random()->id;
        $ticket->type_id = $type_id = Type::all()->random()->id;
        $ticket->status_id = $status_id = Status::all()->random()->id;
        $status = $ticket->save();
        $after = Ticket::count();
        $this->assertTrue($status);
        $this->assertEquals(0, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'created_by', 'product_id', 'type_id', 'status_id'));
    }

    public function test_model_softdeletion()
    {
        $ticket = factory(self::CLASS_NAME)->create();
        $beforeAll = Ticket::count();
        $before = Ticket::onlyTrashed()->count();
        $id = $ticket->id;
        $status = $ticket->delete();
        $afterAll = Ticket::count();
        $after = Ticket::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(1, $after - $before);
        $this->assertSoftDeleted(self::TABLE_NAME, compact('id'));
    }

    public function test_model_deletion()
    {
        $ticket = factory(self::CLASS_NAME)->create();
        $beforeAll = Ticket::count();
        $before = Ticket::onlyTrashed()->count();
        $id = $ticket->id;
        $status = $ticket->forceDelete();
        $afterAll = Ticket::count();
        $after = Ticket::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(0, $after - $before);
        $this->assertDeleted(self::TABLE_NAME, compact('id'));
    }
}
