<?php namespace Scalex\Zero\Transformers;

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
    ];

    protected $defaultIncludes = [
        'sessions',
        'active_sessions',
        'future_sessions',
        'instructors',
    ];

    public function show(Course $course)
    {
        return $this->index($course);
    }

    public function index(Course $course)
    {
        return [
            'name' => (string) $course->name,
            'code' => (string) $course->code,
            'photo' => (string) attach_url($course->photo),
            'description' => (string) $course->description,
            'department_id' => (int) $course->department_id,
            'discipline_id' => $course->discipline_id ? (int) $course->discipline_id : null,
            'year_id' => (int) $course->year_id,
            'year_text' => $this->getYear($course->year_id),
            'semester_id' => $course->semester_id ? (int) $course->semester_id : null,
        ];
    }

    protected function getYear($year)
    {
        switch ($year) {
            case 1: return 'First Year';
            case 2: return 'Second Year';
            case 3: return 'Third Year';
            case 4: return 'Fourth Year';
            default: return 'Any Year';
        }
    }

    public function includeSemester(Course $course)
    {
        return $course->semeseter ? $this->item($course->semeseter) : $this->null();
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

    public function includeSession(Course $course)
    {
        return $this->item($course->session); // NOTE: $course->session is set in Courses/CurrentUserController.
    }

    public function includeSessions(Course $course)
    {
        return $this->collection($course->sessions);
    }

    public function includeActiveSessions(Course $course)
    {
        return $this->collection($course->sessions->filter(function ($session) {
            return $session->ended_on->isFuture();
        }));
    }

    public function includeFutureSessions(Course $course)
    {
        return $this->collection($course->sessions->filter(function ($session) {
            return $session->started_on->isFuture();
        }));
    }

    public function includeInstructors(Course $course)
    {
        return $this->collection($course->instructors);
    }

    public function includePrerequisites(Course $course)
    {
        return $this->collection($course->prerequisites);
    }
}
