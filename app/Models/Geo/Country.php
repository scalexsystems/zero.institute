<?php namespace Scalex\Zero\Models\Geo;

use Scalex\Zero\Models\BaseModel;

class Country extends BaseModel
{
    protected $fillable = ['name', 'code',];

    public function states() {
        return $this->hasMany(State::class);
    }
}
