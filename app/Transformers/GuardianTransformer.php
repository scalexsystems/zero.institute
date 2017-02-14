<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Guardian;
use Znck\Transformers\Transformer;

class GuardianTransformer extends Transformer
{
    public function show(Guardian $guardian)
    {
        return [
            'name' => (string)$guardian->name,

            // Basic Information.
            'first_name' => (string)$guardian->first_name,
            'last_name' => (string)$guardian->last_name,



            'gender' => (string)$guardian->gender,
            'blood_group' => (string)$guardian->blood_group,

            'phone' => $guardian->phone,
            'income' => (float)$guardian->income,
            'profession' => (string)$guardian->profession,
        ];
    }
}
