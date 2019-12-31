<?php

namespace Tests\Unit\Models;

use App\Model\Ticket;
use App\Model\TicketType as Type;
use PDOException;
use Tests\TestCase;

class TicketTypeTest extends TestCase
{
    private const TABLE_NAME = 'ticket_types';
    private const CLASS_NAME = Type::class;

    public function test_not_null_constraint_for_description_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $type = factory(self::CLASS_NAME)->make();
        $type->description = null;
        $type->save();
    }

    public function test_not_null_constraint_for_description_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $type = factory(self::CLASS_NAME)->create();
        $type->description = null;
        $type->save();
    }

    public function test_tickets_relationship()
    {
        $samples = Type::count();
        for ($i = 0; $i < $samples; $i++) {
            $type = Type::all()->random();
            $fromType = $type->tickets;
            $fromTicket = Ticket::where('type_id', $type->id)->orderByDesc('created_at')->get();
            for ($j = 0; $j < $fromType->count(); $j++)
                $this->assertEquals($fromType[$j]->id, $fromTicket[$j]->id);
        }
    }

    public function test_model_saving()
    {
        $before = Type::count();
        $type = factory(self::CLASS_NAME)->make();
        $status = $type->save();
        $id = $type->id;
        $description = $type->description;
        $after = Type::count();
        $this->assertTrue($status);
        $this->assertEquals(1, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'description'));
    }

    public function test_model_update()
    {
        $type = factory(self::CLASS_NAME)->create();
        $before = Type::count();
        $id = $type->id;
        $type->description = $description = 'Other description';
        $status = $type->save();
        $after = Type::count();
        $this->assertTrue($status);
        $this->assertEquals(0, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'description'));
    }

    public function test_model_softdeletion()
    {
        $type = factory(self::CLASS_NAME)->create();
        $beforeAll = Type::count();
        $before = Type::onlyTrashed()->count();
        $id = $type->id;
        $status = $type->delete();
        $afterAll = Type::count();
        $after = Type::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(1, $after - $before);
        $this->assertSoftDeleted(self::TABLE_NAME, compact('id'));
    }

    public function test_model_deletion()
    {
        $type = factory(self::CLASS_NAME)->create();
        $beforeAll = Type::count();
        $before = Type::onlyTrashed()->count();
        $id = $type->id;
        $status = $type->forceDelete();
        $afterAll = Type::count();
        $after = Type::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(0, $after - $before);
        $this->assertDeleted(self::TABLE_NAME, compact('id'));
    }
}
