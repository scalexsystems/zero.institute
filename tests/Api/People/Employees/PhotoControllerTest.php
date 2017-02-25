<?php namespace Tests\Api\People\Employees;

use Scalex\Zero\Events\Employee\PhotoUpdated;

class PhotoControllerTest extends \TestCase
{
    use EmployeeTestHelper;

    public function test_show_can_return_photo()
    {
        $employee = $this->createEmployee();

        $response = $this->actingAs($this->getUser())
                         ->json('GET', '/api/people/employees/'.$employee->uid.'/photo');

        $response->assertStatus(200);
    }

    public function test_store_can_update_photo()
    {
        $employee = $this->createEmployeeAndUser();

        $this->expectsEvents(PhotoUpdated::class);

        $response = $this->actingAs($employee->user)
                         ->postFile('/api/people/employees/'.$employee->uid.'/photo',
                             ['photo' => $this->getSomeImage('photo.jpeg')]);

        $response->assertStatus(202);
    }
}
