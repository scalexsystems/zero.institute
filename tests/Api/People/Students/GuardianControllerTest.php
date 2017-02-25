<?php namespace Tests\Api\People\Students;

use Scalex\Zero\Events\Student\GuardianUpdated;
use Scalex\Zero\Events\Student\Updated;

class GuardianControllerTest extends \TestCase
{
    use StudentTestHelper;

    public function test_father_can_get_guardian_details()
    {
        $student = $this->createStudentAndUser();

        $response = $this->actingAs($student->user)
                         ->json('GET', '/api/people/students/'.$student->uid.'/father');

        $response->assertStatus(200)
                 ->assertJsonStructure(['guardian' => ['id']]);
    }

    public function test_updateFather_can_update_guardian_details()
    {
        $student = $this->createStudentAndUser();
        $payload = ['first_name' => 'Foo'];

        $this->expectsEvents(Updated::class);

        $response = $this->actingAs($student->user)
                         ->put('/api/people/students/'.$student->uid.'/father', $payload);

        $response->assertStatus(200)
                 ->assertJsonStructure(['guardian' => ['id']]);
        $this->assertDatabaseHas('guardians', $payload);
    }

    public function test_mother_can_get_guardian_details()
    {
        $student = $this->createStudentAndUser();

        $response = $this->actingAs($student->user)
                         ->json('GET', '/api/people/students/'.$student->uid.'/mother');

        $response->assertStatus(200)
                 ->assertJsonStructure(['guardian' => ['id']]);
    }

    public function test_updateMother_can_update_guardian_details()
    {
        $student = $this->createStudentAndUser();
        $payload = ['first_name' => 'Foo'];

        $this->expectsEvents(Updated::class);

        $response = $this->actingAs($student->user)
                         ->put('/api/people/students/'.$student->uid.'/mother', $payload);

        $response->assertStatus(200)
                 ->assertJsonStructure(['guardian' => ['id']]);
        $this->assertDatabaseHas('guardians', $payload);
    }
}
