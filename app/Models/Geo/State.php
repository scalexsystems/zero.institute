<?php namespace Scalex\Zero\Models\Geo;

use Scalex\Zero\Models\BaseModel;

class State extends BaseModel
{
    protected $fillable = ['name', 'code', 'country_id'];

    protected $with = ['country'];

    public function country() {
        return $this->belongsTo(Country::class);
    }
}
