<?php namespace Tests\Api\People;

use Scalex\Zero\Action;
use Tests\Api\People\Students\StudentTestHelper;

class StatisticsControllerTest extends \TestCase
{
    use StudentTestHelper;

    public function test_index_can_get_correct_count()
    {
        $this->createStudent(2);

        $response = $this->actingAs($this->getUser())
                         ->givePermissionTo('people.statistics')
                         ->json('GET', '/api/people/statistics');

        $response->assertStatus(200)
                 ->assertJson([
                     'student' => ['count' => 2],
                     'teacher' => ['count' => 0],
                     'employee' => ['count' => 0],
                 ]);
    }
}
