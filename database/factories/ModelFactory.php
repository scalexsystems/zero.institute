<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Scalex\Zero\Models\Geo\Address;
use Scalex\Zero\Models\Geo\City;
use Scalex\Zero\Models\Geo\Country;
use Scalex\Zero\Models\Geo\State;
use Scalex\Zero\Models\School;
use Scalex\Zero\User;


$factory->define(
    Country::class,
    function (Faker\Generator $faker) {
        return [
            'name' => $faker->country,
            'code' => $faker->unique()->countryCode,
        ];
    }
);
$factory->define(
    State::class,
    function (Faker\Generator $f) {
        if (Country::count() > 10) {
            $country_id = Country::find(rand(1, 10))->id;
        }

        return [
            'name' => $f->state,
            'code' => $f->unique()->stateAbbr,
            'country_id' => $country_id ?? function () {
                    return factory(Country::class)->create()->id;
                },
        ];
    }
);
$factory->define(
    City::class,
    function (Faker\Generator $f) {
        if (State::count() > 40) {
            $state_id = State::find(rand(1, 40))->id;
        }

        return [
            'name' => $f->city,
            'code' => $f->unique()->countryCode.' '.$f->unique()->countryISOAlpha3,
            'state_id' => $state_id ?? function () {
                    return factory(State::class)->create()->id;
                },
        ];
    }
);
$factory->define(
    Address::class,
    function (Faker\Generator $f) {
        if (City::count() > 200) {
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
    }
);
$factory->define(
    School::class,
    function (Faker\Generator $f) {
        return [
            'name' => $f->company.' School',
            'slug' => $f->slug(2),
            'website' => $f->url,
            'email' => $f->email,
            'phone' => $f->numerify('+918473######'),
            'fax' => $f->numerify('+918473######'),
            'medium' => $f->randomElement(['en', 'hi']),
            'institute_type' => 'School',
            'timezone' => $f->timezone,
            'verified' => true,
            'university' => 'o',
            'address_id' => function () {
                return factory(Address::class)->create()->id;
            },
        ];
    }
);

$factory->define(
    User::class,
    function (Faker\Generator $faker) {
        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'remember_token' => str_random(10),
            'verification_token' => str_random(10),
            'school_id' => function () {
                return factory(School::class)->create()->id;
            },
        ];
    }
);
