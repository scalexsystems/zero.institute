<?php namespace Tests\Api\People;

use Scalex\Zero\Action;
use Scalex\Zero\Jobs\SendInvitations;

class InvitationControllerTest extends \TestCase
{
    public function test_invite_can_send_student_invitations()
    {
        $payload = [
            'type' => 'student',
            'emails' => ['foo@example.com'],
        ];

        $this->expectsJobs(SendInvitations::class);

        $response = $this->actingAs($this->getUser())
                         ->givePermissionTo('student.invite')
                         ->post('/api/people/invite', $payload);

        $response->assertStatus(202);
    }
}
