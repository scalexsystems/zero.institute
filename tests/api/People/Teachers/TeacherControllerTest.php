<?php namespace Test\Api\People\Teachers;


class TeacherControllerTest extends \Testcase
{
    use TeacherTestHelper;

    const INDEX = [
        'id',
        '_type',
        'created_at',
        'updated_at',
        'uid',
        'name',
        'photo',
        'department_id',
        'has_account',
        'user_id',
    ];

    public function test_index_can_get_teachers()
    {
        $teachers = $this->createTeacher(2);

        $this->actingAs($this->getUser())->get('/api/people/teachers');

        $this->assertResponseStatus(200)
            ->seeJsonStructure(['teachers' => ['*' => self::INDEX]])
            ->seeResources('teachers', $teachers->modelKeys());
    }

    public function test_show_can_get_teacher()
    {
        $teacher = $this->createTeacher();

        $this->actingAs($this->getUser())->get('/api/people/teachers/'.$teacher->uid);

        $this->assertResponseStatus(200)
            ->seeJsonStructure(['teacher' => []]);
    }



}