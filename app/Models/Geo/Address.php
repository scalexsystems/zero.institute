<?php namespace Scalex\Zero\Models\Geo;

use Scalex\Zero\Models\BaseModel;

class Address extends BaseModel
{
    protected $fillable = [
        'address_line1',
        'address_line2',
        'landmark',
        'city_id',
        'pin_code',
        'phone',
        'email',
    ];

    protected $with = ['city'];

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function addressee() {
        return $this->morphTo();
    }
}
