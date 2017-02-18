<?php

namespace Scalex\Zero\Events\Teacher;


use Scalex\Zero\Models\Teacher;

class PhotoUpdated extends AbstractTeacherEvent
{
    public $photo;

    public $user_id;

    public function __construct(Teacher $teacher)
    {
        parent::__construct($teacher);

        $this->user_id = $teacher->user ? $teacher->user->getKey() : 0;

        $this->photo = $teacher->getPhotoUrl();
    }

}