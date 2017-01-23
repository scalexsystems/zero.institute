<?php namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Database\ExtendibleModel;

class Department extends ExtendibleModel implements BelongsToSchool
{
    use SoftDeletes;

    protected $fillable = ['name', 'academic', 'short_name'];

    protected $extends = ['student_count', 'employee_count', 'teacher_count'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function head()
    {
        return $this->belongsTo(Teacher::class);
    }
}
