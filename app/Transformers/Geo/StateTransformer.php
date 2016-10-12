<?php namespace Scalex\Zero\Transformers\Geo;

use Scalex\Zero\Models\Geo\State;
use Znck\Transformers\Transformer;


class StateTransformer extends Transformer
{
    public $defaultIncludes = ['country'];

    protected $timestamps = false;

    public function show(State $state) {
        return [
            'name' => $state->name,
        ];
    }

    public function includeCountry(State $state) {
        return $this->item($state->country);
    }
}
