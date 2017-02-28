<?php namespace Tests\Api\People;

use Tests\Api\People\Students\StudentTestHelper;

class PersonControllerTest extends \TestCase
{
    use StudentTestHelper;

    public function test_index_can_get_all()
    {
        $student = $this->createStudent();
        $student->user()->save($this->getUser());

        $response = $this->actingAs($this->getUser())
                         ->json('GET', '/api/people');

        $response->assertStatus(200);
        $this->seeResources($response, 'items', (array)$student->uid, 'uid');
    }

    public function test_show_can_get_person()
    {
        $student = $this->createStudentAndUser();
        $response = $this->actingAs($this->getUser())
                         ->json('GET', '/api/people/'.$student->user->id);

        $response->assertStatus(200)
                 ->assertJsonStructure(['item' => []]);
    }
}
