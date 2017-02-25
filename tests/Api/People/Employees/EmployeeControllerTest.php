<?php namespace Tests\Api\People\Employees;

class EmployeeControllerTest extends \TestCase
{
    use EmployeeTestHelper;

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

    public function test_index_can_get_employees()
    {
        $employees = $this->createEmployee(2);

        $response = $this->actingAs($this->getUser())->json('GET', '/api/people/employees');

        $response->assertStatus(200)
                 ->assertJsonStructure(['employees' => ['*' => self::INDEX]]);
        $this->seeResources($response, 'employees', $employees->modelKeys());
    }

    public function test_show_can_get_employee()
    {
        $employee = $this->createEmployee();

        $response = $this->actingAs($this->getUser())->json('GET', '/api/people/employees/'.$employee->uid);

        $response->assertStatus(200)
                 ->assertJsonStructure(['employee' => []]);
    }

    public function test_update_can_update_employee()
    {
        $employee = $this->createEmployeeAndUser();

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

        $response = $this->givePermissionTo($this->getUser(), 'employee.update')
                         ->actingAs($this->getUser())
                         ->put('/api/people/employees/'.$employee->uid, $payload);

        $response->assertStatus(200)
                 ->assertJsonStructure(['employee' => []]);
    }
}
