<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Scalex\Zero\Models\Geo\State::class, function (Faker\Generator $f) {
    if (Scalex\Zero\Models\Geo\Country::count() > 10) {
        $country_id = Scalex\Zero\Models\Geo\Country::find(rand(1, 10))->id;
    }

    return [
        'name' => $f->state,
        'code' => $f->unique()->stateAbbr,
        'country_id' => $country_id ?? function () {
                return factory(Scalex\Zero\Models\Geo\Country::class)->create()->id;
            },
    ];
});
