<?php

namespace Tests\Unit\Models;

use App\Model\Product;
use App\Model\Ticket;
use App\Model\TicketMessage as Message;
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

    public function test_status_relationship()
    {
        $samples = ceil(Ticket::count() / 10);
        for ($i = 0; $i < $samples; $i++) {
            $ticket = Ticket::all()->random();
            $fromTicket = $ticket->status;
            $fromStatus = Status::find($ticket->status_id);
            $this->assertEquals($fromTicket->id, $fromStatus->id);
        }
    }

    public function test_type_relationship()
    {
        $samples = ceil(Ticket::count() / 10);
        for ($i = 0; $i < $samples; $i++) {
            $ticket = Ticket::all()->random();
            $fromTicket = $ticket->type;
            $fromType = Type::find($ticket->type_id);
            $this->assertEquals($fromTicket->id, $fromType->id);
        }
    }

    public function test_messages_relationship()
    {
        $samples = ceil(Ticket::count() / 10);
        for ($i = 0; $i < $samples; $i++) {
            $ticket = Ticket::all()->random();
            $fromTicket = $ticket->messages;
            $fromMessage = Message::where('ticket_id', $ticket->id)->orderBy('sent_at')->get();
            for ($j = 0; $j < $fromTicket->count(); $j++)
                $this->assertEquals($fromTicket[$j]->id, $fromMessage[$j]->id);
        }
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

    public function test_model_deletion()
    {
        $ticket = factory(self::CLASS_NAME)->create();
        $before = Ticket::count();
        $id = $ticket->id;
        $status = $ticket->delete();
        $after = Ticket::count();
        $this->assertTrue($status);
        $this->assertEquals(1, $before - $after);
        $this->assertDeleted(self::TABLE_NAME, compact('id'));
    }
}
