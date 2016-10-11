<?php namespace Scalex\Zero\Models\Geo;

use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Database\ExtendibleModel;

class Address extends ExtendibleModel
{
    use SoftDeletes;

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
