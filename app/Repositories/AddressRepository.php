<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Models\Address;
use Znck\Repositories\Repository;

/**
 * @method \Scalex\Zero\Models\Address find(string|int $id)
 * @method Address findBy(string $key, $value)
 * @method \Scalex\Zero\Models\Address create(array $attr)
 * @method Address update(string|int|Address $id, array $attr, array $o = [])
 * @method Address delete(string|int|Address $id)
 * @method AddressRepository validate(array $attr, Address|null $model)
 */
class AddressRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'address_line1' => 'required|max:255',
        'address_line2' => 'required|max:255',
        'landmark' => 'nullable|max:255',
        'city_id' => 'bail|required|exists:cities,id',
        'pin_code' => 'required|digits:6',
        'phone' => 'required',
        'email' => 'nullable|email',
    ];
}
