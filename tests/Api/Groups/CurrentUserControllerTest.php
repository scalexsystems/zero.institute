<?php

namespace Tests\Api\Groups;

use Scalex\Zero\Models\Group;

class CurrentUserControllerTest extends \TestCase
{
    use MessagingTestHelper;

    public function test_index_can_get_groups_user()
    {
        $groups = $this->createPublicGroup(2);
        $groups->each(function (Group $group) {
            $group->addMembers($this->getUser());
        });

        $response = $this->actingAs($this->getUser())->json('GET', '/api/me/groups');
        $response->assertStatus(200)
                 ->assertJsonStructure(['groups']);
        $this->seeResources($response, 'groups', $groups->modelKeys());
    }

    public function test_show_can_get_a_group_for_user()
    {
        $group = $this->createPublicGroup();
        $group->addMembers($this->getUser());

        $response = $this->actingAs($this->getUser())->json('GET', '/api/me/groups/'.$group->id);

        $response->assertStatus(200)
                 ->assertJsonStructure(['group' => ['id']]);
    }
}
