<?php

namespace Test\Api\Groups;

use Illuminate\Database\Eloquent\Collection;
use Scalex\Zero\Contracts\Communication\ReceivesMessage;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Message;

trait MessagingTestHelper
{

    /**
     * Create private groups.
     *
     * @param int $count
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Scalex\Zero\Models\Group
     */
    protected function createPrivateGroup($count = 1)
    {
        return $this->createGroup(['private' => true], $count);
    }

    /**
     * Create public groups.
     *
     * @param int $count
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Scalex\Zero\Models\Group
     */
    protected function createPublicGroup($count = 1)
    {
        return $this->createGroup(['private' => false], $count);
    }

    /**
     * Create course groups.
     *
     * @param int $count
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Scalex\Zero\Models\Group
     */
    protected function createCourseGroup($count = 1)
    {
        return $this->createGroup(['type' => 'course', 'private' => true], $count);
    }

    /**
     * @param array $attributes
     * @param int $count
     *
     * @return \Scalex\Zero\Models\Group|\Illuminate\Database\Eloquent\Collection
     */
    protected function createGroupWithMembers(array $attributes = [], $count = 2)
    {
        $group = $this->createGroup($attributes);
        $users = $this->createUser(['school_id' => $this->getSchool()->id], $count);

        $group->addMembers($users);

        return $group;
    }

    /**
     * Create groups.
     *
     * @param $attributes
     * @param int $count
     *
     * @return \Scalex\Zero\Models\Group|\Illuminate\Database\Eloquent\Collection
     */
    protected function createGroup($attributes, $count = 1)
    {
        $attributes += [
            'school_id' => $this->getSchool()->id,
        ];

        return factory(\Scalex\Zero\Models\Group::class, $count)->create($attributes);
    }

    /**
     * Send messages to the receiver.
     *
     * @param \Scalex\Zero\Models\Group|\Scalex\Zero\User $receiver
     * @param int $count
     *
     * @return \Scalex\Zero\Models\Message|\Illuminate\Database\Eloquent\Collection
     */
    protected function sendMessageTo(ReceivesMessage $receiver, $count = 1)
    {
        $message = factory(Message::class, $count)
            ->create([
                         'receiver_type' => $receiver->getMorphClass(),
                         'receiver_id' => $receiver->getKey(),
                     ]);

        if ($receiver instanceof Group) {
            $receiver->addMembers(($message instanceof Collection ? $message : collect([$message]))
                                      ->map(function (Message $message) {
                                          return $message->sender->id;
                                      }));
        }

        return $message;
    }
}
