<?php

namespace Scalex\Zero\Models;

use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Database\ExtendibleModel;

class FeePayment extends ExtendibleModel implements BelongsToSchool
{
    protected $fillable = ['amount', 'amount_manual', 'deadline'];

    protected $extends = ['amount_manual'];

    protected $casts = [
        'paid' => 'boolean',
        'amount_manual' => 'boolean',
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

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'payable');
    }
}
