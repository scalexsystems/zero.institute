<?php namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Database\BaseModel;

class Attendance extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['date'];

    protected $casts = [
        'attendance' => 'json'
    ];

    public function course_session()
    {
        return $this->belongsTo(CourseSession::class);
    }

}
