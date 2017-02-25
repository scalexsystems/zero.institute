<?php namespace Test\Api\Messages;

use Scalex\Zero\Events\Message\Read;
use Tests\Api\Groups\MessagingTestHelper;

class MessageControllerTest extends \TestCase
{
    use MessagingTestHelper;

    public function test_readAll_can_mark_all_messages_as_read()
    {
        $group = $this->createPublicGroup();
        $group->addMembers($this->getUser());
        $message = $this->sendMessageTo($group);

        $this->expectsEvents(Read::class);
        $this->actingAs($this->getUser())->put('/api/messages/read', ['messages' => $message->id])->assertStatus(202);
        $this->assertDatabaseHas('message_reads', ['message_id' => $message->id, 'user_id' => $this->getUser()->id]);
    }

    public function test_readAll_cannot_mark_all_messages_as_read()
    {
        $group = $this->createPublicGroup();
        $message = $this->sendMessageTo($group);

        $this->doesntExpectEvents(\Scalex\Zero\Events\Message\Read::class);
        $this->actingAs($this->getUser())->put('/api/messages/read', ['messages' => $message->id])->assertStatus(401);
        $this->assertDatabaseMissing('message_reads', ['message_id' => $message->id, 'user_id' => $this->getUser()->id]);
    }

    public function test_readAll_can_mark_all_messages_as_read_to_user()
    {
        $message = $this->sendMessageTo($this->getUser());

        $this->expectsEvents(\Scalex\Zero\Events\Message\Read::class);
        $this->actingAs($this->getUser())->put('/api/messages/read', ['messages' => $message->id])->assertStatus(202);
        $this->assertDatabaseHas('message_reads', ['message_id' => $message->id, 'user_id' => $this->getUser()->id]);
    }

    public function test_readAll_cannot_mark_all_messages_as_read_for_other_member_to_user()
    {
        $message = $this->sendMessageTo($this->createUser());

        $this->doesntExpectEvents(\Scalex\Zero\Events\Message\Read::class);
        $this->actingAs($this->getUser())->put('/api/messages/read', ['messages' => $message->id])->assertStatus(401);
        $this->assertDatabaseMissing('message_reads', ['message_id' => $message->id, 'user_id' => $this->getUser()->id]);
    }
}
