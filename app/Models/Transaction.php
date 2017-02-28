<?php

namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Database\BaseModel;

class Transaction extends BaseModel
{
    use SoftDeletes;

    const PENDING = 'pending';
    const SUCCESSFUL = 'success';
    const FAILED = 'failed';

    protected $fillable = ['purpose', 'description'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function payable()
    {
        return $this->morphTo();
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