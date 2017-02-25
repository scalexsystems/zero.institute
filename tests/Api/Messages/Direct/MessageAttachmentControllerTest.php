<?php namespace Tests\Api\Messages\Direct;

use Tests\Api\Groups\MessagingTestHelper;

class MessageAttachmentControllerTest extends \TestCase
{
    use MessagingTestHelper;

    public function test_store_can_upload_files_to_group()
    {
        $user = $this->createUser();

        $this->actingAs($this->getUser())
             ->postFile('/api/messages/direct/'.$user->id.'/attachment', ['file' => $this->getSomeFile()])
             ->assertStatus(200)
             ->assertJsonStructure(['attachment' => ['id', 'links']]);

        $this->assertDatabaseHas('attachments', []);
    }
}
