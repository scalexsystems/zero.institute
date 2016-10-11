<?php namespace Scalex\Zero\Models\Geo;

use Scalex\Zero\Database\ExtendibleModel;

class Country extends ExtendibleModel
{
    protected $fillable = ['name', 'code',];

    public function states() {
        return $this->hasMany(State::class);
    }
}
