<?php namespace Scalex\Zero\Transformers\Course;

use Scalex\Zero\Models\Course\Session;
use Znck\Transformers\Transformer;

class SessionTransformer extends Transformer
{
    protected $availableIncludes = [
        'group',
        'instructor',
    ];

    public function show(Session $session)
    {
        return $this->index($session);
    }

    public function index(Session $session)
    {
        return [
            'name' => (string)$session->name,
            'syllabus' => (string)$session->syllabus,
            'started_on' => (string)$session->started_on->toIso8601String(),
            'ended_on' => (string)$session->ended_on->toIso8601String(),
            'group_id' => (int)$session->group_id,
            'course_id' => (int)$session->course_id,
            'instructor_id' => (int)$session->instructor_id,
        ];
    }

    public function includeInstructor(Session $session)
    {
        return $this->item($session->instructor);
    }

    public function includeGroup(Session $session)
    {
        return $this->item($session->group);
    }
}
