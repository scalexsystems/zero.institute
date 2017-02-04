<?php namespace Test\Api\Messages;

use Scalex\Zero\Events\Messages\MessageRead;
use Test\Api\Groups\GroupTestsHelper;

class MessageControllerTest extends \TestCase
{
    use GroupTestsHelper;

    public function test_read_can_mark_a_message_as_read() {
        $group = $this->createPublicGroup();
        $group->addMembers($this->getUser());
        $message = $this->sendMessageTo($group);

        $this->expectsEvents(MessageRead::class);
        $this->actingAs($this->getUser())->put('/api/messages/'.$message->id.'/read')->assertResponseStatus(202);
        $this->seeInDatabase('message_reads', ['message_id' => $message->id, 'user_id' => $this->getUser()->id]);
    }

    public function test_read_cannot_mark_a_message_as_read_for_non_member() {
        $group = $this->createPublicGroup();
        $message = $this->sendMessageTo($group);

        $this->doesntExpectEvents(MessageRead::class);
        $this->actingAs($this->getUser())->put('/api/messages/'.$message->id.'/read')->assertResponseStatus(401);
        $this->dontSeeInDatabase('message_reads', ['message_id' => $message->id, 'user_id' => $this->getUser()->id]);
    }

    public function test_readAll_can_mark_all_messages_as_read() {
        $group = $this->createPublicGroup();
        $group->addMembers($this->getUser());
        $message = $this->sendMessageTo($group);

        $this->expectsEvents(MessageRead::class);
        $this->actingAs($this->getUser())->put('/api/messages/read', ['messages' => $message->id])->assertResponseStatus(202);
        $this->seeInDatabase('message_reads', ['message_id' => $message->id, 'user_id' => $this->getUser()->id]);
    }

    public function test_readAll_cannot_mark_all_messages_as_read() {
        $group = $this->createPublicGroup();
        $message = $this->sendMessageTo($group);

        $this->doesntExpectEvents(MessageRead::class);
        $this->actingAs($this->getUser())->put('/api/messages/read', ['messages' => $message->id])->assertResponseStatus(401);
        $this->dontSeeInDatabase('message_reads', ['message_id' => $message->id, 'user_id' => $this->getUser()->id]);
    }

    public function test_read_can_mark_a_message_as_read_to_user() {
        $message = $this->sendMessageTo($this->getUser());

        $this->expectsEvents(MessageRead::class);
        $this->actingAs($this->getUser())->put('/api/messages/'.$message->id.'/read')->assertResponseStatus(202);
        $this->seeInDatabase('message_reads', ['message_id' => $message->id, 'user_id' => $this->getUser()->id]);
    }

    public function test_read_cannot_mark_a_message_as_read_for_other_member_to_user() {
        $message = $this->sendMessageTo($this->createUser());

        $this->doesntExpectEvents(MessageRead::class);
        $this->actingAs($this->getUser())->put('/api/messages/'.$message->id.'/read')->assertResponseStatus(401);
        $this->dontSeeInDatabase('message_reads', ['message_id' => $message->id, 'user_id' => $this->getUser()->id]);
    }

    public function test_readAll_can_mark_all_messages_as_read_to_user() {
        $message = $this->sendMessageTo($this->getUser());

        $this->expectsEvents(MessageRead::class);
        $this->actingAs($this->getUser())->put('/api/messages/read', ['messages' => $message->id])->assertResponseStatus(202);
        $this->seeInDatabase('message_reads', ['message_id' => $message->id, 'user_id' => $this->getUser()->id]);
    }

    public function test_readAll_cannot_mark_all_messages_as_read_for_other_member_to_user() {
        $message = $this->sendMessageTo($this->createUser());

        $this->doesntExpectEvents(MessageRead::class);
        $this->actingAs($this->getUser())->put('/api/messages/read', ['messages' => $message->id])->assertResponseStatus(401);
        $this->dontSeeInDatabase('message_reads', ['message_id' => $message->id, 'user_id' => $this->getUser()->id]);
    }
}
