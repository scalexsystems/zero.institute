<?php namespace Test\Api\Groups;

class MessageAttachmentControllerTest extends \TestCase
{
    use MessagingTestHelper;

    public function test_store_can_upload_files_to_group()
    {
        $group = $this->createPublicGroup();

        $group->addMembers($this->getUser());

        $this->actingAs($this->getUser())
             ->postFile('/api/groups/'.$group->id.'/attachment', ['file' => $this->getSomeFile()])
             ->seeJsonStructure(['attachment' => ['id', 'links']]);
        $this->seeInDatabase('attachments', []);
    }

    public function test_store_cannot_upload_files_to_group_if_user_is_not_a_member()
    {
        $group = $this->createPublicGroup();

        $this->actingAs($this->getUser())
             ->postFile('/api/groups/'.$group->id.'/attachment', ['file' => $this->getSomeFile()])
             ->assertResponseStatus(401);
    }
}
