<?php namespace Scalex\Zero\Models;

use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Database\BaseModel;

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
        return $this->hasMany(CourseSession::class)->orderBy('started_on');
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

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = str_replace(' ', '-', $value);
    }
}
