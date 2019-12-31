<?php

namespace Tests\Unit\Models;

use App\Models\Ticket;
use App\Models\TicketStatus as Status;
use PDOException;
use Tests\TestCase;

class TicketStatusTest extends TestCase
{
    private const TABLE_NAME = 'ticket_status';
    private const CLASS_NAME = Status::class;

    public function test_not_null_constraint_for_name_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $status = factory(self::CLASS_NAME)->make();
        $status->name = null;
        $status->save();
    }

    public function test_not_null_constraint_for_name_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $status = factory(self::CLASS_NAME)->create();
        $status->name = null;
        $status->save();
    }

    public function test_tickets_relationship()
    {
        $samples = Status::count();
        for ($i = 0; $i < $samples; $i++) {
            $status = Status::all()->random();
            $fromStatus = $status->tickets;
            $fromTicket = Ticket::where('status_id', $status->id)->orderByDesc('created_at')->get();
            for ($j = 0; $j < $fromStatus->count(); $j++)
                $this->assertEquals($fromStatus[$j]->id, $fromTicket[$j]->id);
        }
    }

    public function test_model_saving()
    {
        $before = Status::count();
        $status = factory(self::CLASS_NAME)->make();
        $savingStatus = $status->save();
        $id = $status->id;
        $name = $status->name;
        $after = Status::count();
        $this->assertTrue($savingStatus);
        $this->assertEquals(1, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'name'));
    }

    public function test_model_update()
    {
        $status = factory(self::CLASS_NAME)->create();
        $before = Status::count();
        $id = $status->id;
        $status->name = $name = 'Other name';
        $savingStatus = $status->save();
        $after = Status::count();
        $this->assertTrue($savingStatus);
        $this->assertEquals(0, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'name'));
    }

    public function test_model_softdeletion()
    {
        $status = factory(self::CLASS_NAME)->create();
        $beforeAll = Status::count();
        $before = Status::onlyTrashed()->count();
        $id = $status->id;
        $status = $status->delete();
        $afterAll = Status::count();
        $after = Status::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(1, $after - $before);
        $this->assertSoftDeleted(self::TABLE_NAME, compact('id'));
    }

    public function test_model_deletion()
    {
        $status = factory(self::CLASS_NAME)->create();
        $beforeAll = Status::count();
        $before = Status::onlyTrashed()->count();
        $id = $status->id;
        $status = $status->forceDelete();
        $afterAll = Status::count();
        $after = Status::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(0, $after - $before);
        $this->assertDeleted(self::TABLE_NAME, compact('id'));
    }
}
