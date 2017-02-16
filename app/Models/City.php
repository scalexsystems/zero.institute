<?php namespace Scalex\Zero\Models;

use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\Models\State;

class City extends BaseModel
{
    protected $fillable = ['name', 'state_id'];

    protected $searchable = ['name', 'state'];

    protected $with = ['state'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
