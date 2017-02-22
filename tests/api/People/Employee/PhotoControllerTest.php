<?php namespace Test\Api\People\Employees;

use Scalex\Zero\Events\Employee\PhotoUpdated;

class PhotoControllerTest extends \TestCase
{
    use EmployeeTestHelper;

    public function test_show_can_return_photo()
    {
        $employee = $this->createEmployee();

        $this->actingAs($this->getUser())
            ->get('/api/people/employees/'.$employee->uid.'/photo');

        $this->assertResponseStatus(200);
    }

    public function test_store_can_update_photo()
    {
        $employee = $this->createEmployeeAndUser();

        $this->expectsEvents(PhotoUpdated::class);

        $this->actingAs($employee->user)
            ->postFile('/api/people/employees/'.$employee->uid.'/photo', ['photo' => $this->getSomeImage('photo.jpeg')]);

        $this->assertResponseStatus(202);
    }
}
