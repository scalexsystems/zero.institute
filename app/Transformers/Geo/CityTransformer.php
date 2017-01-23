<?php namespace Scalex\Zero\Transformers\Geo;

use Scalex\Zero\Models\Geo\City;
use Znck\Transformers\Transformer;

class CityTransformer extends Transformer
{
    public $availableIncludes = ['state'];

    public $defaultIncludes = ['state'];

    protected $timestamps = false;

    public function index(City $city)
    {
        return [
            'name' => $city->name,
        ];
    }

    public function show(City $city)
    {
        return $this->index($city);
    }

    public function includeState(City $city)
    {
        return $this->item($city->state);
    }
}
