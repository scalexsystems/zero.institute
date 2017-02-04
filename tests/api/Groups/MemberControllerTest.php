<?php

namespace Test\Api\Groups;

use Scalex\Zero\Events\Group\MemberJoined;
use Scalex\Zero\Events\Group\MemberLeft;
use Scalex\Zero\Models\Group;

class MemberControllerTest extends \TestCase
{
    use MessagingTestHelper;

    public function test_index_api_structure()
    {
        $group = $this->createGroupWithMembers(['private' => false]);

        $this->actingAs($this->getUser())->get('/api/groups/'.$group->id.'/members')
             ->assertResponseStatus(200)
             ->seeJsonStructure([
                                    'users' => [
                                        '*' => [
                                            'id',
                                            'type',
                                            'name',
                                            'photo',
                                        ],
                                    ],
                                    'meta' => [
                                        'pagination',
                                    ],
                                ]);
    }

    public function test_index_can_get_members()
    {
        $group = $this->createGroupWithMembers(['private' => false]);

        $this->actingAs($this->getUser())->get('/api/groups/'.$group->id.'/members')
             ->assertResponseStatus(200);
    }

    public function test_index_can_get_members_for_a_member()
    {
        $group = $this->createGroupWithMembers(['private' => true]);

        $group->addMembers($this->getUser());

        $this->actingAs($this->getUser())->get('/api/groups/'.$group->id.'/members')
             ->assertResponseStatus(200);
    }

    public function test_index_cannot_get_members_of_a_private_group()
    {
        $group = $this->createGroupWithMembers(['private' => true]);

        $this->actingAs($this->getUser())->get('/api/groups/'.$group->id.'/members')
             ->assertResponseStatus(401);
    }

    public function test_store_failed_validation_without_members()
    {
        $group = $this->createPrivateGroup();

        $this->actingAs($group->owner)->post('/api/groups/'.$group->id.'/members')
             ->assertResponseStatus(422)
             ->seeJsonStructure(['errors' => ['members']]);
    }

    public function test_store_can_add_members()
    {
        $group = $this->createPrivateGroup();

        $this->expectsEvents(MemberJoined::class);
        $this->expectsModelEvents(Group::class, 'membersAdded');
        $this->actingAs($group->owner)->post('/api/groups/'.$group->id.'/members',
                                             ['members' => $id = $this->createUser()->id])
             ->assertResponseStatus(200);
        $this->seeInDatabase('group_user', ['group_id' => $group->id, 'user_id' => $id]);
    }

    public function test_store_only_owner_can_add_members()
    {
        $group = $this->createPrivateGroup();
        $user = $this->createUser();

        $group->addMembers($user);

        $this->actingAs($user)->post('/api/groups/'.$group->id.'/members',
                                     ['members' => $this->createUser()->id])
             ->assertResponseStatus(401);
    }

    public function test_delete_failed_validation_without_members()
    {
        $group = $this->createPrivateGroup();

        $this->actingAs($group->owner)->delete('/api/groups/'.$group->id.'/members')
             ->assertResponseStatus(422)
             ->seeJsonStructure(['errors' => ['members']]);
    }

    public function test_delete_can_remove_members()
    {
        $group = $this->createPrivateGroup();
        $user = $this->createUser();

        $group->addMembers($user);

        $this->seeInDatabase('group_user', ['group_id' => $group->id, 'user_id' => $user->id]);
        $this->expectsEvents(MemberLeft::class);
        $this->expectsModelEvents(Group::class, 'membersRemoved');
        $this->actingAs($group->owner)->delete('/api/groups/'.$group->id.'/members',
                                             ['members' => $user->id])
             ->assertResponseStatus(200);
        $this->dontSeeInDatabase('group_user', ['group_id' => $group->id, 'user_id' => $user->id]);
    }

    public function test_owner_cannot_remove_himself()
    {
        $group = $this->createPrivateGroup();

        $group->addMembers($group->owner_id);

        $this->seeInDatabase('group_user', ['group_id' => $group->id, 'user_id' => $group->owner->id]);
        $this->doesntExpectModelEvents(Group::class, 'membersRemoved');
        $this->doesntExpectEvents(MemberLeft::class);
        $this->actingAs($group->owner)->delete('/api/groups/'.$group->id.'/members',
                                               ['members' => $group->owner->id])
             ->assertResponseStatus(200);
        $this->seeInDatabase('group_user', ['group_id' => $group->id, 'user_id' => $group->owner->id]);
    }

    public function test_delete_only_owner_can_add_members()
    {
        $group = $this->createPrivateGroup();
        $user = $this->createUser();

        $group->addMembers($user);

        $this->actingAs($user)->post('/api/groups/'.$group->id.'/members',
                                     ['members' => $this->createUser()->id])
             ->assertResponseStatus(401);
    }
}
