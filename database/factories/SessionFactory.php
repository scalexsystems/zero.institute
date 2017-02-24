<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\CourseSession;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Department;
use Scalex\Zero\Models\Discipline;
use Scalex\Zero\Models\Attachment;
use Faker\Generator;
use Scalex\Zero\Models\Teacher;

$factory->define(CourseSession::class, function (Generator $f, array $attributes) {

    $attributes['school_id'] = $attributes['school_id'] ?? factory(School::class)->create()->id;

    $attributes['course_id'] = $attributes['course_id'] ?? factory(Course::class)->create()->id;

    $attributes['instructor_id'] = $attributes['instructor_id'] ?? factory(Teacher::class)->create()->id;

    return [
        'name' => $f->name,
        'course_id' => $attributes['course_id'],
        'group_id' => factory(Group::class)->create(),

        'school_id' => $attributes['school_id'],
        // TODO:: change it to meaningful dates if necessary
        'start_date' => $f->date(),
        'end_date' => $f->date(),
    ];
});
