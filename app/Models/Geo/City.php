<?php namespace Scalex\Zero\Models\Geo;

use Scalex\Zero\Models\BaseModel;

class City extends BaseModel
{
    protected $fillable = ['name', 'state_id'];

    protected $searchable = ['name'];

    protected $with = ['state'];

    public function state() {
        return $this->belongsTo(State::class);
    }
}
