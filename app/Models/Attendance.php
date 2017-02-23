<?php

namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['course_session_id', 'student_id', 'date'];

    protected $dates = ['date'];

    public function course_session()
    {
        return $this->belongsTo(CourseSession::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
