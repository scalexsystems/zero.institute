<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Models\Attendance;
use Scalex\Zero\Models\CourseSession;

$factory->define(Attendance::class, function (Generator $f, array $attributes) {

    $attributes['course_session_id'] = $attributes['course_session_id'] ?? factory(CourseSession::class)->create()->id;

    $attributes['student_id'] = $attributes['student_id'] ?? factory(Student::class)->create()->id;
    return [
        'course_session_id' => $attributes['course_session_id'],
        'date' => $f->date(),
        'attendance' => json_encode([$attributes['student_id'] => false]),
    ];
});
