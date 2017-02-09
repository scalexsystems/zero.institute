<?php namespace Test\Api\People\Employees;



use Scalex\Zero\Events\Employee\EmployeePhotoUpdated;

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
        $employee = $this->createEmployee();

        $this->expectsEvents(EmployeePhotoUpdated::class);

        $this->actingAs($employee->user)
            ->postFile('/api/people/employee/'.$employee->uid.'/photo', ['photo' => $this->getSomeFile('photo.jpg')]);

        $this->assertResponseStatus(202);
    }
}
