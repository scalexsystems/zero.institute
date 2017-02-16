<?php namespace Test\Api\People\Students;

use Scalex\Zero\Events\Student\PhotoUpdated;

class PhotoControllerTest extends \TestCase
{
    use StudentTestHelper;

    public function test_show_can_return_photo()
    {
        $student = $this->createStudent();

        $this->actingAs($this->getUser())
             ->get('/api/people/students/'.$student->uid.'/photo');

        $this->assertResponseStatus(200);
    }

    public function test_store_can_update_photo()
    {
        $student = $this->createStudentAndUser();

        $this->expectsEvents(PhotoUpdated::class);

        $this->actingAs($student->user)
             ->postFile('/api/people/students/'.$student->uid.'/photo', ['photo' => $this->getSomeFile('photo.jpg')]);

        $this->assertResponseStatus(202);
    }
}
