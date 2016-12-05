<?php namespace Scalex\Zero\Models;

use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Models\Department;
use Scalex\Zero\Models\Discipline;
use Scalex\Zero\Models\Attachment;

class Course extends BaseModel implements BelongsToSchool
{
    protected $fillable = ['name', 'code', 'description'];

    public function school() {
        return $this->belongsTo(School::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function discipline() {
        return $this->belongsTo(Discipline::class);
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function intructor() {
        return $this->belongsTo(Teacher::class);
    }

    public function photo() {
        return $this->belongsTo(Attachment::class);
    }
}
