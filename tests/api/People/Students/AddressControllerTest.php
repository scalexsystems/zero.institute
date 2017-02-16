<?php namespace Test\Api\People\Students;

use Scalex\Zero\Action;
use Scalex\Zero\Events\Student\StudentAddressUpdated;
use Scalex\Zero\Models\Address;

class AddressControllerTest extends \TestCase
{
    use StudentTestHelper;

    public function test_show_cannot_return_address_without_permissions()
    {
        $student = $this->createStudent();

        $this->actingAs($this->getUser())
             ->get('/api/people/students/'.$student->uid.'/address');

        $this->assertResponseStatus(401);
    }

    public function test_show_can_return_address_if_user_has_permission()
    {
        $student = $this->createStudent();

        $this->actingAs($this->getUser())
             ->givePermissionTo(Action::VIEW_STUDENT)
             ->get('/api/people/students/'.$student->uid.'/address');

        $this->assertResponseStatus(200)
             ->seeJsonStructure(['address' => ['address_line1', 'address_line2', 'city']]);
    }

    public function test_show_can_return_address_to_user_himself()
    {
        $student = $this->createStudent();
        $student->user()->save($this->getUser());

        $this->actingAs($this->getUser())
             ->get('/api/people/students/'.$student->uid.'/address');

        $this->assertResponseStatus(200)
             ->seeJsonStructure(['address' => ['address_line1', 'address_line2', 'city']]);
    }

    public function test_update_can_change_student_address()
    {
        $student = $this->createStudent();
        $payload = ['address_line1' => 'Foo'];

        $this->expectsEvents(StudentAddressUpdated::class)
             ->expectsModelEvents(Address::class, 'updated');

        $this->actingAs($this->getUser())
             ->givePermissionTo(Action::VIEW_STUDENT)
             ->givePermissionTo(Action::UPDATE_STUDENT)
             ->post('/api/people/students/'.$student->uid.'/address', $payload);

        $this->assertResponseStatus(200)
             ->seeJsonStructure(['address' => ['address_line1', 'address_line2', 'city']])
             ->seeInDatabase('addresses', $payload);
    }
}
