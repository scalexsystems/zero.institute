<?php namespace Test\Api\People\Students;

class StudentControllerTest extends \TestCase
{
    use StudentTestHelper;

    const INDEX = [
        'id',
        '_type',
        'created_at',
        'updated_at',
        'uid',
        'name',
        'photo',
        'department_id',
        'discipline_id',
        'has_account',
        'user_id',
    ];

    public function test_index_can_get_students()
    {
        $students = $this->createStudent(2);

        $this->actingAs($this->getUser())->get('/api/people/students');

        $this->assertResponseStatus(200)
             ->seeJsonStructure(['students' => ['*' => self::INDEX]])
             ->seeResources('students', $students->modelKeys());
    }

    public function test_show_can_get_student()
    {
        $student = $this->createStudent();

        $this->actingAs($this->getUser())->get('/api/people/students/'.$student->uid);

        $this->assertResponseStatus(200)
             ->seeJsonStructure(['student' => []]);
    }
}
