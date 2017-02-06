<?php namespace Scalex\Zero\Events\Student;

use Scalex\Zero\Models\Student;

class GuardianUpdated extends AbstractStudentEvent
{

    /**
     * Type of guardian.
     *
     * @var string
     */
    public $type;

    public function __construct(Student $student, string $type)
    {
        parent::__construct($student);
        $this->type = $type;
    }
}
