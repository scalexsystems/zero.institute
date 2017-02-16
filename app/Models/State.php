<?php namespace Scalex\Zero\Models;

use Scalex\Zero\Database\ExtendibleModel;
use Scalex\Zero\Models\Country;

class State extends ExtendibleModel
{
    protected $fillable = ['name', 'code', 'country_id'];

    protected $with = ['country'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
