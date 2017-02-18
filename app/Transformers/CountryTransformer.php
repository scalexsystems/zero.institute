<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Country;
use Znck\Transformers\Transformer;

class CountryTransformer extends Transformer
{
    protected $timestamps = false;

    public function show(Country $model)
    {
        return [
            'name' => $model->name,
        ];
    }
}
