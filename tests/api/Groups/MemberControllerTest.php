<?php

use Scalex\Zero\Models\Group;
use Scalex\Zero\User;

class MemberControllerTest extends TestCase
{
    public function createGroup($attributes = []) {
        return factory(Group::class)->create($attributes);
    }

    public function test_it_can_list_all_members() {
        $user = $this->createAnUser();
        $group = $this->createGroup([
            'school_id' => $user->school_id,
            'owner_id' => $user->id,
        ]);
        $users = factory(User::class, 2)->create();
        $group->addMembers([$user->id]);
        $group->addMembers(collect($users)->keys()->toArray());

        $this->actingAs($user)
            ->json('GET', "/api/groups/{$group->id}/members")
            ->seeJson()
            ->seeJsonContains(transform($group->members));
    }

    public function test_it_can_add_members() {
        $user = $this->createAnUser();
        $other = $this->createAnUser(['school_id' => $user->school_id]);
        $group = $this->createGroup(['school_id' => $user->school_id, 'owner_id' => $user->id]);
        $group->addMembers([$user->id]);

        $data = [
            'members' => [(string)$other->id],
        ];

        $this->actingAs($user)
            ->json('POST', "/api/groups/{$group->id}/members/add", $data)
            ->seeJson()
            ->seeJsonContains($data['members'])
            ->seeInDatabase('group_user', [
                'user_id' => $user->id,
                'group_id' => $group->id,
            ]);
    }

    public function test_it_can_remove_members() {
        $user = $this->createAnUser();
        $other = $this->createAnUser(['school_id' => $user->school_id]);
        $group = $this->createGroup(['school_id' => $user->school_id, 'owner_id' => $user->id]);
        $group->addMembers([$user->id, $other->id]);

        $data = [
            'members' => [(string)$other->id],
        ];

        $this->actingAs($user)
            ->json('DELETE', "/api/groups/{$group->id}/members/remove", $data)
            ->seeJson()
            ->seeJsonContains($data['members'])
            ->dontSeeInDatabase('group_user', [
                'user_id' => $other->id,
                'group_id' => $group->id,
            ]);
    }
}
