<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Scalex\Zero\Models\Geo\City::class, function (Faker\Generator $f) {
    if (Scalex\Zero\Models\Geo\State::count() > 40) {
        $state_id = Scalex\Zero\Models\Geo\State::find(rand(1, 40))->id;
    }

    return [
        'name' => $f->city,
        'code' => $f->unique()->countryCode.' '.$f->unique()->countryISOAlpha3,
        'state_id' => $state_id ?? function () {
            return factory(Scalex\Zero\Models\Geo\State::class)->create()->id;
        },
    ];
});
