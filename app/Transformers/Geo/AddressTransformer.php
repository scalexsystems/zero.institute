<?php namespace Scalex\Zero\Transformers\Geo;

use Scalex\Zero\Models\Geo\Address;
use Znck\Transformers\Transformer;

class AddressTransformer extends Transformer
{
    public $availableIncludes = ['city'];

    public $defaultIncludes = ['city'];

    public function show(Address $address) {
        return [
            'address_line1' => (string)$address->address_line1,
            'address_line2' => (string)$address->address_line2,
            'landmark' => (string)$address->landmark,
            'pin_code' => (string)$address->pin_code,
            'phone' => (string)$address->phone,
            'email' => (string)$address->email,
            'city_id' => (string)$address->city_id,
        ];
    }

    public function includeCity(Address $address) {
        return $this->item($address->city);
    }
}
