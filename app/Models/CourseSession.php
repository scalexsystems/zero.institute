<?php

namespace Scalex\Zero\Models;

use Scalex\Zero\Database\BaseModel;

class CourseSession extends BaseModel
{
    protected $fillable = ['name', 'started_on', 'ended_on', 'syllabus'];

    protected $extends = ['syllabus'];

    protected $dates = ['started_on', 'ended_on'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_session_student')->withTimestamps();
    }
}
