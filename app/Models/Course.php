<?php namespace Scalex\Zero\Models;

use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Models\Department;
use Scalex\Zero\Models\Discipline;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\Course\Session;
use Scalex\Zero\Models\Course\Constraint;
use Scalex\Zero\Models\Semester;

class Course extends BaseModel implements BelongsToSchool
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = ['name', 'code', 'description'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    public function instructors()
    {
        return $this->belongsToMany(Teacher::class)->withTimestamps();
    }

    public function prerequisites()
    {
        return $this->hasMany(Constraint::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function photo()
    {
        return $this->belongsTo(Attachment::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class)->orderBy('started_on');
    }
}
