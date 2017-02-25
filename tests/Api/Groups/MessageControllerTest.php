<?php namespace Tests\Api\Groups;

use Scalex\Zero\Events\Message\Created;

class MessageControllerTest extends \TestCase
{
    use MessagingTestHelper;

    public function test_index_can_get_group_messages()
    {
        $group = $this->createPublicGroup();

        $group->addMembers($this->getUser());

        $messages = $this->sendMessageTo($group, 2);

        $this->assertDatabaseHas('messages', []);
        $response = $this->actingAs($this->getUser())
                         ->json('GET', '/api/groups/'.$group->id.'/messages');
        $response->assertStatus(200)
                 ->assertJsonStructure(['messages' => ['*' => ['id', 'content', 'sender']]]);
        $this->seeResources($response, 'messages', $messages->modelKeys());
    }

    public function test_index_cannot_serve_group_messages_to_non_members()
    {
        $group = $this->createPublicGroup();

        $this->sendMessageTo($group, 2);

        $this->assertDatabaseHas('messages', []);
        $this->actingAs($this->getUser())->json('GET', '/api/groups/'.$group->id.'/messages')
             ->assertStatus(401);
    }

    public function test_store_can_send_message()
    {
        $group = $this->createPublicGroup();

        $group->addMembers($this->getUser());

        $this->expectsEvents(Created::class);
        $this->actingAs($this->getUser())->post('/api/groups/'.$group->id.'/messages', ['content' => 'foo'])
             ->assertStatus(200)
             ->assertJsonStructure(['message' => ['id', 'content', 'sender']]);
        $this->assertDatabaseHas('messages', ['content' => 'foo']);
    }

    public function test_store_cannot_send_message_for_non_member()
    {
        $group = $this->createPublicGroup();

        $this->doesntExpectEvents(Created::class);
        $this->actingAs($this->getUser())->post('/api/groups/'.$group->id.'/messages', ['content' => 'foo'])
             ->assertStatus(401);
    }
}
