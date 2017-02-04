<?php namespace Test\Api\Messages\Direct;

use Scalex\Zero\Events\Message\NewMessage;
use Test\Api\Groups\MessagingTestHelper;

class MessageControllerTest extends \TestCase
{
    use MessagingTestHelper;

    public function test_index_can_get_user_messages()
    {
        $message = $this->sendMessageTo($this->getUser());

        $this->seeInDatabase('messages', []);
        $this->actingAs($this->getUser())->get('/api/messages/direct/'.$message->sender->id.'/messages')
             ->assertResponseStatus(200)
             ->seeJsonStructure(['messages' => ['*' => ['id', 'content', 'sender']]])
             ->seeResources('messages', (array) $message->id);
    }

    public function test_store_can_send_message()
    {
        $user = $this->createUser();

        $this->expectsEvents(NewMessage::class);
        $this->actingAs($this->getUser())->post('/api/messages/direct/'.$user->id.'/messages', ['content' => 'foo'])
             ->assertResponseStatus(200)
             ->seeJsonStructure(['message' => ['id', 'content', 'sender']]);
        $this->seeInDatabase('messages', ['content' => 'foo', 'sender_id' => $this->getUser()->id, 'receiver_id' => $user->id]);
    }
}
