<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\City;
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

    public function show(\Scalex\Zero\Models\City $city)
    {
        return $this->index($city);
    }

    public function includeState(\Scalex\Zero\Models\City $city)
    {
        return $this->item($city->state);
    }
}
