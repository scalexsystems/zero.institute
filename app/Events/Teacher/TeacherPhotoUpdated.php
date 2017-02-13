<?php namespace Scalex\Zero\Events\Teacher;


use Scalex\Zero\Models\Teacher;

class TeacherPhotoUpdated extends AbstractTeacherEvent
{
    public $photo;

    public function __construct(Teacher $teacher)
    {
        parent::__construct($teacher);

        $this->photo = $teacher->getPhotoUrl();
    }

}