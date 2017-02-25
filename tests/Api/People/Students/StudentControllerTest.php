<?php namespace Tests\Api\People\Students;

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

        $response = $this->actingAs($this->getUser())->json('GET', '/api/people/students');

        $response->assertStatus(200)
                 ->assertJsonStructure(['students' => ['*' => self::INDEX]]);
        $this->seeResources($response, 'students', $students->modelKeys());
    }

    public function test_show_can_get_student()
    {
        $student = $this->createStudent();

        $response = $this->actingAs($this->getUser())->json('GET', '/api/people/students/'.$student->uid);

        $response->assertStatus(200)
                 ->assertJsonStructure(['student' => []]);
    }

    public function test_update_can_update_student()
    {
        $student = $this->createStudentAndUser();

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

        $response = $this->givePermissionTo($this->getUser(), 'student.update')
                         ->actingAs($this->getUser())
                         ->put('/api/people/students/'.$student->uid, $payload);

        $response->assertStatus(200)
                 ->assertJsonStructure(['student' => []]);
    }
}
