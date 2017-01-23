<?php namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Database\ExtendibleModel;

class Discipline extends ExtendibleModel implements BelongsToSchool
{
    use SoftDeletes;

    protected $fillable = ['name', 'short_name'];

    protected $extends = ['student_count'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
