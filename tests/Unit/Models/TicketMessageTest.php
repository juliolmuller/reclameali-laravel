<?php

namespace Tests\Unit\Models;

use App\Model\Ticket;
use App\Model\TicketMessage as Message;
use App\Model\User;
use PDOException;
use Tests\TestCase;

class TicketMessageTest extends TestCase
{
    private const TABLE_NAME = 'ticket_messages';
    private const CLASS_NAME = Message::class;

    public function test_not_null_constraint_for_messageBody_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $message = factory(self::CLASS_NAME)->make();
        $message->message_body = null;
        $message->save();
    }

    public function test_not_null_constraint_for_messageBody_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $message = factory(self::CLASS_NAME)->create();
        $message->message_body = null;
        $message->save();
    }

    public function test_not_null_constraint_for_ticket_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $message = factory(self::CLASS_NAME)->make();
        $message->ticket_id = null;
        $message->save();
    }

    public function test_not_null_constraint_for_ticket_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $message = factory(self::CLASS_NAME)->create();
        $message->ticket_id = null;
        $message->save();
    }

    public function test_not_null_constraint_for_sentBy_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $message = factory(self::CLASS_NAME)->make();
        $message->sent_by = null;
        $message->save();
    }

    public function test_not_null_constraint_for_sentBy_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $message = factory(self::CLASS_NAME)->create();
        $message->sent_by = null;
        $message->save();
    }

    public function test_not_null_constraint_for_sentAt_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $message = factory(self::CLASS_NAME)->make();
        $message->sent_at = null;
        $message->save();
    }

    public function test_not_null_constraint_for_sentAt_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $message = factory(self::CLASS_NAME)->create();
        $message->sent_at = null;
        $message->save();
    }

    public function test_model_saving()
    {
        $before = Message::count();
        $message = factory(self::CLASS_NAME)->make();
        $status = $message->save();
        $id = $message->id;
        $message_body = $message->message_body;
        $ticket_id = $message->ticket_id;
        $sent_by = $message->sent_by;
        $sent_at = $message->sent_at;
        $after = Message::count();
        $this->assertTrue($status);
        $this->assertEquals(1, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'message_body', 'ticket_id', 'sent_by', 'sent_at'));
    }

    public function test_model_update()
    {
        $message = factory(self::CLASS_NAME)->create();
        $before = Message::count();
        $now = now();
        $id = $message->id;
        $message->message_body = $message_body = 'New Message';
        $message->ticket_id = $ticket_id = Ticket::all()->random()->id;
        $message->sent_by = $sent_by = User::all()->random()->id;
        $message->sent_at = $sent_at = $now;
        $status = $message->save();
        $after = Message::count();
        $this->assertTrue($status);
        $this->assertEquals(0, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'message_body', 'ticket_id', 'sent_by', 'sent_at'));
    }

    public function test_model_softdeletion()
    {
        $message = factory(self::CLASS_NAME)->create();
        $beforeAll = Message::count();
        $before = Message::onlyTrashed()->count();
        $id = $message->id;
        $status = $message->delete();
        $afterAll = Message::count();
        $after = Message::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(1, $after - $before);
        $this->assertSoftDeleted(self::TABLE_NAME, compact('id'));
    }

    public function test_model_deletion()
    {
        $message = factory(self::CLASS_NAME)->create();
        $beforeAll = Message::count();
        $before = Message::onlyTrashed()->count();
        $id = $message->id;
        $status = $message->forceDelete();
        $afterAll = Message::count();
        $after = Message::onlyTrashed()->count();
        $this->assertTrue($status);
        $this->assertEquals(1, $beforeAll - $afterAll);
        $this->assertEquals(0, $after - $before);
        $this->assertDeleted(self::TABLE_NAME, compact('id'));
    }
}
