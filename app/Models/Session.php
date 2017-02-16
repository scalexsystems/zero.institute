<?php

namespace Scalex\Zero\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Database\BaseModel;

class Session extends BaseModel
{
    use SoftDeletes;

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
