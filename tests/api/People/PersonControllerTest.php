<?php namespace Test\Api\People;

use Test\Api\People\Students\StudentTestHelper;

class PersonControllerTest extends \TestCase
{
    use StudentTestHelper;

    public function test_index_can_get_all()
    {
        $student = $this->createStudent();
        $student->user()->save($this->getUser());

        $this->actingAs($this->getUser())
             ->get('/api/people');

        $this->assertResponseStatus(200)
             ->seeResources('items', (array) $student->uid, 'uid');
    }

    public function test_show_can_get_person()
    {
        $student = $this->createStudentAndUser();
        $this->actingAs($this->getUser())
            ->get('/api/people/' . $student->user->id);

        $this->assertResponseStatus(200)
            ->seeJsonStructure(['item' => []]);
    }
}
