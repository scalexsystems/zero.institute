<?php namespace Test\Api\People\Students;

use Scalex\Zero\Events\Student\GuardianUpdated;
use Scalex\Zero\Events\Student\Updated;

class GuardianControllerTest extends \TestCase
{
    use StudentTestHelper;

    public function test_father_can_get_guardian_details()
    {
        $student = $this->createStudentAndUser();

        $this->actingAs($student->user)
             ->get('/api/people/students/'.$student->uid.'/father');

        $this->assertResponseStatus(200)
             ->seeJsonStructure(['guardian' => ['id']]);
    }

    public function test_updateFather_can_update_guardian_details()
    {
        $student = $this->createStudentAndUser();
        $payload = ['first_name' => 'Foo'];

        $this->expectsEvents(Updated::class);

        $this->actingAs($student->user)
             ->put('/api/people/students/'.$student->uid.'/father', $payload);

        $this->assertResponseStatus(200)
             ->seeJsonStructure(['guardian' => ['id']])
             ->seeInDatabase('guardians', $payload);
    }

    public function test_mother_can_get_guardian_details()
    {
        $student = $this->createStudentAndUser();

        $this->actingAs($student->user)
             ->get('/api/people/students/'.$student->uid.'/mother');

        $this->assertResponseStatus(200)
             ->seeJsonStructure(['guardian' => ['id']]);
    }

    public function test_updateMother_can_update_guardian_details()
    {
        $student = $this->createStudentAndUser();
        $payload = ['first_name' => 'Foo'];

        $this->expectsEvents(Updated::class);
        
        $this->actingAs($student->user)
             ->put('/api/people/students/'.$student->uid.'/mother', $payload);

        $this->assertResponseStatus(200)
             ->seeJsonStructure(['guardian' => ['id']])
             ->seeInDatabase('guardians', $payload);
    }
}
