<?php

namespace Tests\Unit\Models;

use App\Models\Ticket;
use App\Models\TicketMessage as Message;
use App\Models\User;
use PDOException;
use Tests\TestCase;

class TicketMessageTest extends TestCase
{
    private const TABLE_NAME = 'ticket_messages';
    private const CLASS_NAME = Message::class;

    public function test_not_null_constraint_for_body_on_insert()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $message = factory(self::CLASS_NAME)->make();
        $message->body = null;
        $message->save();
    }

    public function test_not_null_constraint_for_body_on_update()
    {
        $this->expectException(PDOException::class);
        $this->expectExceptionCode(23502);
        $message = factory(self::CLASS_NAME)->create();
        $message->body = null;
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

    public function test_createdBy_relationship()
    {
        $samples = ceil(Message::count() / 10);
        for ($i = 0; $i < $samples; $i++) {
            $message = Message::all()->random();
            $fromMessage = $message->sender;
            $fromUser = User::find($message->sender->id);
            $this->assertEquals($fromMessage->id, $fromUser->id);
        }
    }

    public function test_ticket_relationship()
    {
        $samples = ceil(Message::count() / 10);
        for ($i = 0; $i < $samples; $i++) {
            $message = Message::all()->random();
            $fromMessage = $message->ticket;
            $fromTicket = Ticket::find($message->ticket_id);
            $this->assertEquals($fromMessage->id, $fromTicket->id);
        }
    }

    public function test_model_saving()
    {
        $before = Message::count();
        $message = factory(self::CLASS_NAME)->make();
        $status = $message->save();
        $id = $message->id;
        $body = $message->body;
        $ticket_id = $message->ticket_id;
        $sent_by = $message->sent_by;
        $sent_at = $message->sent_at;
        $after = Message::count();
        $this->assertTrue($status);
        $this->assertEquals(1, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'body', 'ticket_id', 'sent_by', 'sent_at'));
    }

    public function test_model_update()
    {
        $message = factory(self::CLASS_NAME)->create();
        $before = Message::count();
        $now = now();
        $id = $message->id;
        $message->body = $body = 'New Message';
        $message->ticket_id = $ticket_id = Ticket::all()->random()->id;
        $message->sent_by = $sent_by = User::all()->random()->id;
        $message->sent_at = $sent_at = $now;
        $status = $message->save();
        $after = Message::count();
        $this->assertTrue($status);
        $this->assertEquals(0, $after - $before);
        $this->assertDatabaseHas(self::TABLE_NAME, compact('id', 'body', 'ticket_id', 'sent_by', 'sent_at'));
    }

    public function test_model_deletion()
    {
        $message = factory(self::CLASS_NAME)->create();
        $before = Message::count();
        $id = $message->id;
        $status = $message->delete();
        $after = Message::count();
        $this->assertTrue($status);
        $this->assertEquals(1, $before - $after);
        $this->assertDeleted(self::TABLE_NAME, compact('id'));
    }
}
