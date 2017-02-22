<?php namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Database\ExtendibleModel;

class Discipline extends ExtendibleModel implements BelongsToSchool
{
    use SoftDeletes;

    protected $fillable = ['name', 'short_name'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
