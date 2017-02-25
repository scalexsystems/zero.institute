<?php namespace Tests\Api\People\Students;

use Scalex\Zero\Events\Student\StudentAddressUpdated;
use Scalex\Zero\Events\Student\Updated;

class AddressControllerTest extends \TestCase
{
    use StudentTestHelper;

    public function test_show_cannot_return_address_without_permissions()
    {
        $student = $this->createStudent();

        $response = $this->actingAs($this->getUser())
                         ->json('GET', '/api/people/students/'.$student->uid.'/address');

        $response->assertStatus(401);
    }

    public function test_show_can_return_address_if_user_has_permission()
    {
        $student = $this->createStudent();

        $response = $this->actingAs($this->getUser())
                         ->givePermissionTo('student.read')
                         ->json('GET', '/api/people/students/'.$student->uid.'/address');

        $response->assertStatus(200)
                 ->assertJsonStructure(['address' => ['address_line1', 'address_line2', 'city']]);
    }

    public function test_show_can_return_address_to_user_himself()
    {
        $student = $this->createStudent();
        $student->user()->save($this->getUser());

        $response = $this->actingAs($this->getUser())
                         ->json('GET', '/api/people/students/'.$student->uid.'/address');

        $response->assertStatus(200)
                 ->assertJsonStructure(['address' => ['address_line1', 'address_line2', 'city']]);
    }

    public function test_update_can_change_student_address()
    {
        $student = $this->createStudent();
        $payload = ['address_line1' => 'Foo'];

        $this->expectsEvents(Updated::class);
//             ->expectsModelEvents(Address::class, 'updated'); // Not supported.

        $response = $this->actingAs($this->getUser())
                         ->givePermissionTo('student.read')
                         ->givePermissionTo('student.update')
                         ->put('/api/people/students/'.$student->uid.'/address', $payload);

        $response->assertStatus(200)
                 ->assertJsonStructure(['address' => ['address_line1', 'address_line2', 'city']]);
        $this->assertDatabaseHas('addresses', $payload);
    }
}
