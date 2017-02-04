<?php namespace Test\Api\Messages;

use Test\Api\Groups\GroupTestsHelper;

class CurrentUserControllerTest extends \TestCase
{
    use GroupTestsHelper;

    public function test_index_can_get_conversation_users()
    {
        $senders = $this->sendMessageTo($this->getUser(), 2)->map(function ($message) {
            return $message->sender;
        });

        $this->actingAs($this->getUser())->get('/api/me/users');
        $this->assertResponseStatus(200)
             ->seeResources('users', $senders->pluck('id')->toArray());
    }

    public function test_show_can_get_any_user()
    {
        $user = $this->createUser();

        $this->actingAs($this->getUser())->get('/api/me/users/'.$user->id);
        $this->assertResponseStatus(200)->seeJsonStructure(['user']);
    }
}
