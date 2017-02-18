<?php

namespace Scalex\Zero\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Database\BaseModel;

class Session extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'started_on',
        'ended_on',
    ];

    protected $dates = [
        'started_on',
        'ended_on'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
