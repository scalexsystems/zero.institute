<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\School;
use Znck\Transformers\Transformer;


class SchoolTransformer extends Transformer
{
    public function show(School $model) {
        return [
            'name' => $model->name,
        ];
    }

    public function index(School $school) {
        return [
            'name' => $school->name,
            'logo' => $this->logo($school),
            'extra' => ($school->relationLoaded('address') and $school->address)
                ? [
                    'city' => $school->address->city->name,
                    'state' => $school->address->city->state->name,
                ]
                : [
                    'city' => '',
                    'state' => '',
                ],
        ];
    }

    /**
     * @param \Scalex\Zero\Models\School $school
     *
     * @return string
     */
    protected function logo(School $school) {
        return ($school->relationLoaded('logo') and $school->logo)
            ? attach_url($school->logo)
            : asset('img/placeholder-64.jpg');
    }
}
