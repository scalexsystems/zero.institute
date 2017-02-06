<?php namespace Test\Api\People\Teachers;


use Scalex\Zero\Action;

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

    public function test_update_can_update_teacher()
    {
        $student = $this->createTeacher();

        $payload = [
            // Basic Information.
            'first_name' => 'Foo',
            'last_name' => 'Bar',
            'middle_name' => 'Baz',
            'date_of_birth' => '1996-08-12',
            'gender' => 'male',
            'blood_group' => 'A+',
            'category' => 'gen',
            'religion' => 'Hindu',
            'language' => 'Hindi',
            'passport' => 'xxxx4131',
            'govt_id' => '111122223333',

            // Related to School.
            'uid' => '123456',
            'date_of_admission' => '2017-02-01',
            'boarding_type' => 'hosteler',
            'biometric_id' => 'b123456',

            // Medical Information.
            'is_disabled' => true,
            'disability' => 'None',
            'disease' => 'Node',
            'allergy' => 'None',
            'visible_marks' => 'None',
            'food_habit' => 'veg',
            'medical_remarks' => 'None',

            // Maintenance Information.
            'remarks' => 'None',
        ];

        $this->givePermissionTo($this->getUser(), Action::UPDATE_TEACHER)
            ->actingAs($this->getUser())
            ->put('/api/people/teachers/'.$student->uid, $payload);

        $this->assertResponseStatus(200)
            ->seeJsonStructure(['teacher' => []]);
    }




}