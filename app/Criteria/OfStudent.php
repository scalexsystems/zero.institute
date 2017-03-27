<?php

namespace Scalex\Zero\Criteria;

use Scalex\Zero\Models\Student;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class OfStudent implements Criteria
{
    /**
     * @var \Scalex\Zero\Models\Student
     */
    protected $student;

    /**
     * OfStudent constructor.
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function apply($model, Repository $repository)
    {
        $model->where('student_id', $this->student->getKey());
    }
}
