<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\State;
use Znck\Transformers\Transformer;

class StateTransformer extends Transformer
{
    public $defaultIncludes = ['country'];

    protected $timestamps = false;

    public function show(State $state)
    {
        return [
            'name' => $state->name,
        ];
    }

    public function includeCountry(\Scalex\Zero\Models\State $state)
    {
        return $this->item($state->country);
    }
}
