<?php

namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Database\BaseModel;

class FeeSession extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['name', 'started_at', 'ended_at'];

    protected $extends = ['fee_details_url'];

    protected $dates = [
        'ended_at',
        'started_at',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
