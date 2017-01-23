<?php namespace Scalex\Zero\Transformers\Course;

use Scalex\Zero\Models\Course\Session;
use Znck\Transformers\Transformer;

class SessionTransformer extends Transformer
{
    protected $availableIncludes = [
        'instructor',
    ];

    protected $defaultIncludes = [
        'group',
    ];

    public function show(Session $session)
    {
        return [
            'name' => (string) $session->name,
            'started_on' => (string) $session->started_on->toIso8601String(),
            'ended_on' => (string) $session->ended_on->toIso8601String(),
            'group_id' => (int) $session->group_id,
            'instructor_id' => (int) $session->instructor_id,
        ];
    }

    public function index(Session $session)
    {
        return $this->show($session);
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
