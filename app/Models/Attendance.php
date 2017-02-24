<?php namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;

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
