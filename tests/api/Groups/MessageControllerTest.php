<?php namespace Test\Api\Groups;

use Scalex\Zero\Events\Message\NewMessage;

class MessageControllerTest extends \TestCase
{
    use MessagingTestHelper;

    public function test_index_can_get_group_messages()
    {
        $group = $this->createPublicGroup();

        $group->addMembers($this->getUser());

        $messages = $this->sendMessageTo($group, 2);

        $this->seeInDatabase('messages', []);
        $this->actingAs($this->getUser())->get('/api/groups/'.$group->id.'/messages')
             ->assertResponseStatus(200)
             ->seeJsonStructure(['messages' => ['*' => ['id', 'content', 'sender']]])
             ->seeResources('messages', $messages->modelKeys());
    }

    public function test_index_cannot_serve_group_messages_to_non_members()
    {
        $group = $this->createPublicGroup();

        $this->sendMessageTo($group, 2);

        $this->seeInDatabase('messages', []);
        $this->actingAs($this->getUser())->get('/api/groups/'.$group->id.'/messages')
             ->assertResponseStatus(401);
    }

    public function test_store_can_send_message()
    {
        $group = $this->createPublicGroup();

        $group->addMembers($this->getUser());

        $this->expectsEvents(NewMessage::class);
        $this->actingAs($this->getUser())->post('/api/groups/'.$group->id.'/messages', ['content' => 'foo'])
             ->assertResponseStatus(200)
             ->seeJsonStructure(['message' => ['id', 'content', 'sender']]);
        $this->seeInDatabase('messages', ['content' => 'foo']);
    }

    public function test_store_cannot_send_message_for_non_member()
    {
        $group = $this->createPublicGroup();

        $this->doesntExpectEvents(NewMessage::class);
        $this->actingAs($this->getUser())->post('/api/groups/'.$group->id.'/messages', ['content' => 'foo'])
             ->assertResponseStatus(401);
    }
}
