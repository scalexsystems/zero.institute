<?php namespace Tests\Api\People\Teachers;

use Scalex\Zero\Events\Teacher\PhotoUpdated;

class PhotoControllerTest extends \TestCase
{
    use TeacherTestHelper;

    public function test_show_can_return_photo()
    {
        $teacher = $this->createTeacher();

        $response = $this->actingAs($this->getUser())
                         ->json('GET', '/api/people/teachers/'.$teacher->uid.'/photo');

        $response->assertStatus(200);
    }

    public function test_store_can_update_photo()
    {
        $teacher = $this->createTeacherAndUser();

        $this->expectsEvents(PhotoUpdated::class);

        $response = $this->actingAs($teacher->user)
                         ->postFile('/api/people/teachers/'.$teacher->uid.'/photo',
                             ['photo' => $this->getSomeImage('photo.jpeg')]);

        $response->assertStatus(202);
    }
}
