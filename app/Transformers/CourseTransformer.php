<?php namespace Scalex\Zero\Transformers;

use Gate;
use Scalex\Zero\Models\Course;
use Znck\Transformers\Transformer;
use Carbon\Carbon;

class CourseTransformer extends Transformer
{
    protected $availableIncludes = [
        'school',
        'department',
        'discipline',
        'instructors',
        'session',
        'semester',
        'prerequisites',
        'sessions',
        'instructors',
    ];

    public function show(Course $course)
    {
        return $this->index($course);
    }

    public function index(Course $course)
    {
        return [
            'name' => (string)$course->name,
            'code' => (string)$course->code,
            'photo' => (string)$course->getPhotoUrl(),
            'description' => (string)$course->description,
            'department_id' => (int)$course->department_id,
            'discipline_id' => $course->discipline_id ? (int)$course->discipline_id : null,
            'year_id' => (int)$course->year_id,
            'year_text' => $this->getYear($course->year_id),
            'semester_id' => $course->semester_id ? (int)$course->semester_id : null,
        ];
    }

    protected function getYear($year)
    {
        switch ($year) {
            case 1:
                return 'First Year';
            case 2:
                return 'Second Year';
            case 3:
                return 'Third Year';
            case 4:
                return 'Fourth Year';
            default:
                return 'Any Year';
        }
    }

    public function includeSemester(Course $course)
    {
        return $this->item($course->semester);
    }

    public function includeSchool(Course $course)
    {
        return $this->item($course->school);
    }

    public function includeDepartment(Course $course)
    {
        return $this->item($course->department);
    }

    public function includeDiscipline(Course $course)
    {
        return $this->item($course->discipline);
    }

    public function includeSessions(Course $course)
    {
        return $this->collection($course->sessions);
    }

    public function includeActiveSessions(Course $course)
    {
        return $this->collection($course->sessions->filter(function (Course\Session $session) {
            return $session->started_on->isPast() and $session->ended_on->isFuture();
        }));
    }

    public function includeFutureSessions(Course $course)
    {
        return $this->collection($course->sessions->filter(function (Course\Session $session) {
            return $session->started_on->isFuture();
        }));
    }

    public function includeInstructors(Course $course)
    {
        if (Gate::allows('view-instructors', $course)) {
            return $this->collection($course->instructors);
        }

        return $this->collection([]);
    }

    public function includePrerequisites(Course $course)
    {
        return $this->collection($course->prerequisites);
    }
}
