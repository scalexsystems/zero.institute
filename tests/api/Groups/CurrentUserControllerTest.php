<?php

namespace Test\Api\Groups;

use Scalex\Zero\Models\Group;

class CurrentUserControllerTest extends \TestCase
{
    use GroupTestsHelper;

    public function test_index_can_get_groups_user() {
        $groups = $this->createPublicGroup(2);
        $groups->each(function (Group $group) {
            $group->addMembers($this->getUser());
        });

        $this->actingAs($this->getUser())->get('/api/me/groups')
             ->assertResponseStatus(200)
             ->seeResources('groups', $groups->modelKeys())
             ->seeJsonStructure(['groups']);
    }

    public function test_show_can_get_a_group_for_user() {
        $group = $this->createPublicGroup();
        $group->addMembers($this->getUser());

        $this->actingAs($this->getUser())->get('/api/me/groups/'.$group->id)
             ->assertResponseStatus(200)
             ->seeJsonStructure(['group' => ['id']]);
    }
}
