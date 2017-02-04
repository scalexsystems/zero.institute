<?php namespace Test\Api\Messages\Direct;

use Test\Api\Groups\MessagingTestHelper;

class MessageAttachmentControllerTest extends \TestCase
{
    use MessagingTestHelper;

    public function test_store_can_upload_files_to_group()
    {
        $user = $this->createUser();

        $this->actingAs($this->getUser())
             ->postFile('/api/messages/direct/'.$user->id.'/attachment', ['file' => $this->getSomeFile()]);
        
        $this->assertResponseStatus(200)->seeJsonStructure(['attachment' => ['id', 'links']]);
        $this->seeInDatabase('attachments', []);
    }
}
