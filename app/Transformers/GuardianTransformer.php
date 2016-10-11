<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Guardian;
use Znck\Transformers\Transformer;


class GuardianTransformer extends Transformer
{
    protected $availableIncludes = ['address'];

    public function show(Guardian $guardian) {
        return [
            'name' => (string)$guardian->name,

            // Basic Information.
            'first_name' => (string)$guardian->first_name,
            'middle_name' => (string)$guardian->middle_name,
            'last_name' => (string)$guardian->last_name,
            'date_of_birth' => iso_date($guardian->date_of_birth),
            'gender' => (string)$guardian->gender,
            'blood_group' => (string)$guardian->blood_group,
            'category' => (string)$guardian->category,
            'religion' => (string)$guardian->religion,
            'language' => (string)$guardian->language,
            'passport' => (string)$guardian->passport,
            'govt_id' => (string)$guardian->govt_id,

            // Medical Information.
            'is_disabled' => (boolean)$guardian->is_disabled,
            'disability' => (string)$guardian->disability,
            'disease' => (string)$guardian->disease,
            'allergy' => (string)$guardian->allergy,
            'visible_marks' => (string)$guardian->visible_marks,
            'food_habit' => (string)$guardian->food_habit,
            'medical_remarks' => (string)$guardian->medical_remarks,
        ];
    }


    public function includeAddress(Guardian $guardian) {
        return allow(
            'read-address', $guardian,
            $this->item($guardian->address, transformer($guardian->address)),
            $this->null()
        );
    }
}
