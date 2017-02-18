<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\CourseSession;
use Znck\Transformers\Transformer;

class CourseSessionTransformer extends Transformer
{
    protected $availableIncludes = [
        'group',
        'instructor',
    ];

    public function show(CourseSession $session)
    {
        return $this->index($session);
    }

    public function index(CourseSession $session)
    {
        return [
            'name' => (string)$session->name,
            'syllabus' => (string)$session->syllabus,
            'started_on' => (string)$session->started_on->toIso8601String(),
            'ended_on' => (string)$session->ended_on->toIso8601String(),
            'group_id' => (int)$session->group_id,
            'course_id' => (int)$session->course_id,
            'session_id' => (int)$session->session_id,
            'instructor_id' => (int)$session->instructor_id,
        ];
    }

    public function includeInstructor(CourseSession $session)
    {
        return $this->item($session->instructor);
    }

    public function includeGroup(CourseSession $session)
    {
        return $this->item($session->group);
    }
}
