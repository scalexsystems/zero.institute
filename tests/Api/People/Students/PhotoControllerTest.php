<?php namespace Tests\Api\People\Students;

use Scalex\Zero\Events\Student\PhotoUpdated;

class PhotoControllerTest extends \TestCase
{
    use StudentTestHelper;

    public function test_show_can_return_photo()
    {
        $student = $this->createStudent();

        $response = $this->actingAs($this->getUser())
                         ->json('GET', '/api/people/students/'.$student->uid.'/photo');

        $response->assertStatus(200);
    }

    public function test_store_can_update_photo()
    {
        $student = $this->createStudentAndUser();

        $this->expectsEvents(PhotoUpdated::class);

        $response = $this->actingAs($student->user)
                         ->postFile('/api/people/students/'.$student->uid.'/photo',
                             ['photo' => $this->getSomeImage('photo.jpeg')]);

        $response->assertStatus(202);
    }
}
