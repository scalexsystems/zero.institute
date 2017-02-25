<?php namespace Tests\Api\People\Teachers;

class TeacherControllerTest extends \TestCase
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

        $response = $this->actingAs($this->getUser())->json('GET', '/api/people/teachers');

        $response->assertStatus(200)
                 ->assertJsonStructure(['teachers' => ['*' => self::INDEX]]);
        $this->seeResources($response, 'teachers', $teachers->modelKeys());
    }

    public function test_show_can_get_teacher()
    {
        $teacher = $this->createTeacher();

        $response = $this->actingAs($this->getUser())
                         ->json('GET', '/api/people/teachers/'.$teacher->uid);

        $response->assertStatus(200)
                 ->assertJsonStructure(['teacher' => []]);
    }

    public function test_update_can_update_teacher()
    {
        $student = $this->createTeacherAndUser();

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
            'food_habit' => ['veg'],
            'medical_remarks' => 'None',

            // Maintenance Information.
            'remarks' => 'None',
        ];

        $response = $this->givePermissionTo($this->getUser(), 'teacher.update')
                         ->actingAs($this->getUser())
                         ->put('/api/people/teachers/'.$student->uid, $payload);

        $response->assertStatus(200)
                 ->assertJsonStructure(['teacher' => []]);
    }
}
