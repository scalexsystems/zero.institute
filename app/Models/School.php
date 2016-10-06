<?php namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Models\Geo\Address;

class School extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'address_id',
        'website',
        'email',
        'phone',
        'fax',
        'university',
        'institute_type',
        'verified',
    ];

    protected $casts = [
        'verified' => 'bool',
    ];

    public function address() {
        return $this->belongsTo(Address::class);
    }

    public function logo() {
        return $this->belongsTo(Attachment::class);
    }
}
