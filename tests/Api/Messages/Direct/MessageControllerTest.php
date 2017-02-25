<?php namespace Tests\Api\Messages\Direct;

use Scalex\Zero\Events\Message\Created;
use Tests\Api\Groups\MessagingTestHelper;

class MessageControllerTest extends \TestCase
{
    use MessagingTestHelper;

    public function test_index_can_get_user_messages()
    {
        $message = $this->sendMessageTo($this->getUser());

        $this->assertDatabaseHas('messages', []);
        $response = $this->actingAs($this->getUser())
                         ->json('GET', '/api/messages/direct/'.$message->sender->id.'/messages');

        $response->assertStatus(200)
                 ->assertJsonStructure(['messages' => ['*' => ['id', 'content', 'sender']]]);

        $this->seeResources($response, 'messages', (array)$message->id);
    }

    public function test_store_can_send_message()
    {
        $user = $this->createUser();

        $this->expectsEvents(Created::class);
        $this->actingAs($this->getUser())->post('/api/messages/direct/'.$user->id.'/messages', ['content' => 'foo'])
             ->assertStatus(200)
             ->assertJsonStructure(['message' => ['id', 'content', 'sender']]);
        $this->assertDatabaseHas('messages',
            ['content' => 'foo', 'sender_id' => $this->getUser()->id, 'receiver_id' => $user->id]);
    }
}
