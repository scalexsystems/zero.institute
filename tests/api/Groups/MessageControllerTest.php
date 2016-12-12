<?php
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Message;

class MessageControllerTest extends TestCase
{
    public function createGroup($attributes = []) {
        return factory(Group::class)->create($attributes);
    }

    public function test_it_can_list_all_messages() {
        $user = $this->createAnUser();
        $group = $this->createGroup(['school_id' => $user->school_id]);
        $group->addMembers([$user->id]);
        $messages = factory(Message::class, 2)->create([
            'sender_id' => $user->id,
            'receiver_id' => $group->id,
            'receiver_type' => 'group',
        ]);

        $this->actingAs($user)
            ->json('GET', "/api/groups/{$group->id}/messages")
            ->seeStatusCode(200)
            ->seeJsonContains(transform($messages));
    }

    public function test_it_can_send_a_message() {
        $user = $this->createAnUser();
        $group = $this->createGroup(['school_id' => $user->school_id]);
        $group->addMembers([$user->id]);
        $data = [
            'content' => 'Test Message',
        ];

        $this->actingAs($user)
            ->json('POST', "/api/groups/{$group->id}/messages", $data)
            ->seeStatusCode(200)
            ->seeJsonContains($data)
            ->seeInDatabase('messages', [
                'sender_id' => $user->id,
                'receiver_id' => $group->id,
            ]);
    }

    public function test_it_can_set_message_read() {
        $user = $this->createAnUser();
        $other = $this->createAnUser(['school_id' => $user->school_id]);
        $group = $this->createGroup(['school_id' => $user->school_id]);
        $group->addMembers([$user->id, $other->id]);

        $message = factory(Message::class)->create([
            'sender_id' => $other->id,
            'receiver_id' => $group->id,
            'receiver_type' => 'group',
        ]);

        $this->actingAs($user)
            ->json('PUT', "/api/groups/{$group->id}/messages/{$message->id}/read")
            ->seeStatusCode(202)
            ->seeInDatabase('message_reads', [
                'user_id' => $user->id,
                'message_id' => $message->id,
            ]);
    }
}
