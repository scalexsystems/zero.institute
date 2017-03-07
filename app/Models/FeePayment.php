<?php

namespace Scalex\Zero\Models;

use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Database\BaseModel;

class FeePayment extends BaseModel implements BelongsToSchool
{
    protected $fillable = ['amount'];

    protected $casts = [
        'paid' => false,
    ];

    protected $dates = [
        'deadline',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feeSession()
    {
        return $this->belongsTo(FeeSession::class);
    }
}
