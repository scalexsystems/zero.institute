<?php namespace Scalex\Zero\Models;

use Scalex\Zero\Database\ExtendibleModel;
use Scalex\Zero\Models\State;

class Country extends ExtendibleModel
{
    protected $fillable = ['name', 'code',];

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
