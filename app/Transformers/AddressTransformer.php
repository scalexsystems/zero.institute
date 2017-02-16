<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Address;
use Znck\Transformers\Transformer;

class AddressTransformer extends Transformer
{
    public $availableIncludes = ['city'];

    public $defaultIncludes = ['city'];

    public function show(\Scalex\Zero\Models\Address $address)
    {
        return [
            'address_line1' => (string)$address->address_line1,
            'address_line2' => (string)$address->address_line2,
            'landmark' => (string)$address->landmark,
            'pin_code' => (string)$address->pin_code,
            'phone' => (string)$address->phone,
            'email' => (string)$address->email,
            'city_id' => (int)$address->city_id,
        ];
    }

    public function includeCity(\Scalex\Zero\Models\Address $address)
    {
        return $this->item($address->city);
    }
}
