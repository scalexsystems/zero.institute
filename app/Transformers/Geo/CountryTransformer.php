<?php namespace Scalex\Zero\Transformers\Geo;

use Scalex\Zero\Models\Geo\Country;
use Znck\Transformers\Transformer;


class CountryTransformer extends Transformer
{
    protected $timestamps = false;

    public function show(Country $model) {
        return [
            'name' => $model->name,
        ];
    }
}
