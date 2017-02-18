<?php namespace Test\Api\People;

use Scalex\Zero\Action;
use Test\Api\People\Students\StudentTestHelper;

class StatisticsControllerTest extends \TestCase
{
    use StudentTestHelper;

    public function test_index_can_get_correct_count()
    {
        $this->createStudent(2);

        $this->actingAs($this->getUser())
             ->givePermissionTo(Action::PEOPLE)
             ->get('/api/people/statistics');

        $this->assertResponseStatus(200)
             ->seeJson([
                           'student' => ['count' => 2],
                           'teacher' => ['count' => 0],
                           'employee' => ['count' => 0],
                       ]);
    }
}
