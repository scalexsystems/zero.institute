<?php

namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\User;

class Transaction extends BaseModel
{
    use SoftDeletes;

    const PENDING = 'pending';
    const SUCCESSFUL = 'success';
    const FAILED = 'failed';

    protected $fillable = [
        'amount',
        'status',
        'refundable',
        'gateway',
        'gateway_reference_id',
        'payment_method',
        'dd_number',
        'cheque_number',
        'accountant_id',
        'purpose',
        'description',
    ];

    protected $extends = [
        'dd_number',
        'cheque_number',
        'accountant_id',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function payable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPending()
    {
        return $this->status === static::PENDING;
    }

    public function isSuccessful()
    {
        return $this->status === static::SUCCESSFUL;
    }

    public function isFailed()
    {
        return $this->status === static::FAILED;
    }
}