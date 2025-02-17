<?php namespace Scalex\Zero\Events\Student;

use Scalex\Zero\Models\Student;

class PhotoUpdated extends AbstractStudentEvent
{
    public $photo;

    public function __construct(Student $student)
    {
        parent::__construct($student);

        $this->photo = $student->getPhotoUrl();
    }
}
