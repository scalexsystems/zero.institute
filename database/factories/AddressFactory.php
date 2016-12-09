<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */


$factory->define(Scalex\Zero\Models\Address::class, function (Faker\Generator $f) {
    if (Scalex\Zero\Models\Geo\City::count() > 200) {
        $city_id = City::find(rand(1, 200))->id;
    }

    return [
        'address_line1' => $f->streetAddress,
        'address_line2' => $f->streetName,
        'landmark' => $f->optional()->streetSuffix,
        'pin_code' => $f->numerify('######'),
        'phone' => $f->numerify('+918473######'),
        'email' => $f->email,
        'city_id' => $city_id ?? function () {
            return factory(City::class)->create()->id;
        },
    ];
});
