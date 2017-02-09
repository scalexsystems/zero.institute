<?php namespace Test\Api\People\Teachers;


use Scalex\Zero\Events\Teacher\TeacherPhotoUpdated;

class PhotoControllerTest extends \TestCase
{

    use TeacherTestHelper;

    public function test_show_can_return_photo()
    {
        $teacher = $this->createTeacher();

        $this->actingAs($this->getUser())
            ->get('/api/people/teachers/'.$teacher->uid.'/photo');

        $this->assertResponseStatus(200);
    }

    public function test_store_can_update_photo()
    {
        $teacher = $this->createTeacher();

        $this->expectsEvents(TeacherPhotoUpdated::class);

        $this->actingAs($teacher->user)
            ->postFile('/api/people/teacher/'.$teacher->uid.'/photo', ['photo' => $this->getSomeFile('photo.jpg')]);

        $this->assertResponseStatus(202);
    }
}
