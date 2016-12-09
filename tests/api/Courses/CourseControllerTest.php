<?php

use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Department;
use Scalex\Zero\User;

class CourseControllerTest extends TestCase
{
    public function test_it_lists_courses() {
        $user = $this->createAnUser();
        factory(Course::class, 2)->create(['school_id' => $user->school_id]);

        $this->actingAs($user)
            ->json('GET', '/api/courses')
            ->seeJson()
            ->seeJsonContains(transform(Course::all()));
    }

    public function test_it_shows_course() {
        $user = $this->createAnUser();
        $course = factory(Course::class)->create(['school_id' => $user->school_id]);

        $this->actingAs($user)
            ->json('GET', "/api/courses/{$course->id}")
            ->seeJson()
            ->seeJsonContains(transform($course));
    }

    public function test_it_can_create_a_course() {
        $user = $this->createAnUser();
        $data = [
            'name' => 'Linear Algebra',
            'code' => 'MA205',
            'department_id' => factory(Department::class)->create(['school_id' => $user->school_id])->id,
        ];

        $this->givePermissionTo($user, 'course.create');

        $this->actingAs($user)
            ->json('POST', '/api/courses', $data)
            ->seeStatusCode(200)
            ->seeJsonContains($data)
            ->seeInDatabase('courses', $data);
    }

    public function test_it_can_update_a_course() {
        $user = $this->createAnUser();
        $course = factory(Course::class)->create(['school_id' => $user->school_id]);
        $data = [
            'department_id' => factory(Department::class)->create(['school_id' => $user->school_id])->id,
        ];

        $this->givePermissionTo($user, 'course.update');

        $this->actingAs($user)
            ->json('PUT', "/api/courses/{$course->id}", $data)
            ->seeStatusCode(200)
            ->seeJsonContains($data)
            ->seeInDatabase('courses', $data);
    }

    public function test_it_can_delete_a_course() {
        $user = $this->createAnUser();
        $course = factory(Course::class)->create(['school_id' => $user->school_id]);

        $this->givePermissionTo($user, 'course.delete');

        $this->actingAs($user)
            ->json('DELETE', "/api/courses/{$course->id}")
            ->seeStatusCode(202)
            ->seeInDatabase('courses', ['id' => $course->id])
            ->dontSeeInDatabase('courses', ['deleted_at' => null]);
    }
}
