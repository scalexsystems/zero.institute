<?php

namespace Test\Api\Groups;

class ProfilePhotoControllerTest extends \TestCase
{
    use GroupTestsHelper;

    public function test_store_can_update_group_photo() {
        $group = $this->createPublicGroup();

        $photo = $this->getSomeFile('photo.png');

        $this->actingAs($group->owner)->postFile('/api/groups/'.$group->id.'/photo', compact('photo'))
             ->assertResponseStatus(202);
        $this->seeInDatabase('attachments', []);
        $this->dontSeeInDatabase('groups', ['photo_id' => null]);
    }

    public function test_store_cannot_update_group_photo_for_non_owner() {
        $group = $this->createPublicGroup();

        $group->addMembers($this->getUser());

        $photo = $this->getSomeFile('photo.png');

        $this->actingAs($this->getUser())->postFile('/api/groups/'.$group->id.'/photo', compact('photo'))
             ->assertResponseStatus(401);
    }

    public function test_destroy_can_remove_group_photo() {
        $group = $this->createPublicGroup();

        $this->actingAs($group->owner)->delete('/api/groups/'.$group->id.'/photo')->assertResponseStatus(202);
        $this->seeInDatabase('groups', ['photo_id' => null]);
    }

    public function test_destroy_cannot_remove_group_photo_for_non_owner() {
        $group = $this->createPublicGroup();
        $group->addMembers($this->getUser());

        $this->actingAs($this->getUser())->delete('/api/groups/'.$group->id.'/photo')->assertResponseStatus(401);
    }
}
