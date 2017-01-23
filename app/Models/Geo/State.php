<?php namespace Scalex\Zero\Models\Geo;

use Scalex\Zero\Database\ExtendibleModel;

class State extends ExtendibleModel
{
    protected $fillable = ['name', 'code', 'country_id'];

    protected $with = ['country'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
