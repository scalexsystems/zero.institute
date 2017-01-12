<?php

namespace Scalex\Zero\Models\Course;

use Scalex\Zero\Database\BaseModel as Model;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Models\Student;

class Session extends Model
{
    protected $table = 'course_sessions';

    protected $fillable = ['name', 'started_on', 'ended_on'];

    protected $dates = ['started_on', 'ended_on'];

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function instructor() {
        return $this->belongsTo(Teacher::class);
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function students() {
        return $this->belongsToMany(Student::class, 'course_session_student');
    }
}
