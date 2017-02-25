<?php namespace Tests\Api\Messages;

use Tests\Api\Groups\MessagingTestHelper;

class CurrentUserControllerTest extends \TestCase
{
    use MessagingTestHelper;

    public function test_index_can_get_conversation_users()
    {
        $senders = $this->sendMessageTo($this->getUser(), 2)->map(function ($message) {
            return $message->sender;
        });

        $response = $this->actingAs($this->getUser())->json('GET', '/api/me/users');

        $response->assertStatus(200);
        $this->seeResources($response, 'users', $senders->pluck('id')->toArray());
    }

    public function test_show_can_get_any_user()
    {
        $user = $this->createUser();

        $this->actingAs($this->getUser())
             ->json('GET', '/api/me/users/'.$user->id)
             ->assertStatus(200)
             ->assertJsonStructure(['user']);
    }
}
