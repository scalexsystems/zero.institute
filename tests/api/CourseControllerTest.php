<?php

use Scalex\Zero\Models\Course;
use Scalex\Zero\User;

class CourseControllerTest extends TestCase
{

    public function test_it_lists_courses() {
        $user = factory(User::class)->create();
        factory(Course::class, 10)->create();

        $this->actingAs($user)
            ->json('GET', '/api/courses')
            ->seeJson()
            ->seeJsonContains(transform(Course::paginate()));
    }
}
