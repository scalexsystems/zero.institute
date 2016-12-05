<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Course;
use Znck\Transformers\Transformer;


class CourseTransformer extends Transformer
{
    protected $availableIncludes = [
        'school',
        'department',
        'discipline',
        'instructor',
        'group',
    ];

    public function show(Course $course) {
        return $this->index($course);
    }

    public function index(Course $course) {
        return [
            'name' => (string) $course->name,
            'code' => (string) $course->code,
            'photo' => (string) attach_url($course->photo) ?? asset('img/placeholder-64.jpg'),
            'description' => (string) $course->description,
            'department_id' => (int) $course->department_id,
            'discipline_id' => (int) $course->discipline_id,
            'instructor_id' => (int) $course->instructor_id,
            'group_id' => (int) $course->group_id,
        ];
    }

    public function includeSchool(Course $course) {
        return $this->item($course->school);
    }

    public function includeDepartment(Course $course) {
        return $this->item($course->department);
    }

    public function includeDiscipline(Course $course) {
        return $this->item($course->discipline);
    }

    public function includeGroup(Course $course) {
        return $this->item($course->group);
    }

    public function includeInstructor(Course $course) {
        return $this->item($course->instructor);
    }
}
