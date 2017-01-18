<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\School;
use Znck\Transformers\Transformer;


class SchoolTransformer extends Transformer
{
    protected $availableIncludes = ['address'];

    public function show(School $school) {
        return [
            'name' => $school->name,
            'logo' => $this->logo($school),
            'logo_id' => (string)$school->logo_id,
            'email' => (string)$school->email,
            'fax' => (string)$school->fax,
            'medium' => (string)$school->medium,
            'website' => (string)$school->website,
            'university' => (string)$school->university,
            'institute_type' => (string)$school->institute_type,
            'verified' => (boolean)$school->verified,
            'slug' => $school->slug,
        ];
    }

    public function index(School $school) {
        return [
            'name' => $school->name,
            'logo' => $this->logo($school),
            'extra' => [
                'city' => $school->address->city->name ?? '',
                'state' => $school->address->city->state->name ?? '',
            ],
        ];
    }

    public function includeAddress(School $school) {
        return $school->address ? $this->item($school->address, transformer($school->address)) : null;
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
