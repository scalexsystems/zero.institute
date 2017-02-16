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

    protected $fillable = [
        'name',
        'code',
        'description',
        'years',
    ];

    protected $extends = ['years'];

    protected $casts = [
        'years' => 'array',
    ];

    public function photo()
    {
        return $this->belongsTo(Attachment::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function sessions()
    {
        return $this->hasMany(Session::class)->orderBy('started_on');
    }

    public function prerequisites()
    {
        return $this->belongsToMany(Course::class, 'course_prerequisite', 'course_id', 'prerequisite_id')
                    ->withTimestamps();
    }

    public function getPhotoUrl()
    {
        return attach_url($this->photo) ?? asset('img/placeholder.jpg');
    }

    /**
     * @deprecated
     */
    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    /**
     * @deprecated
     */
    public function instructors()
    {
        return $this->belongsToMany(Teacher::class)->withTimestamps();
    }

    /**
     * @deprecated
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
