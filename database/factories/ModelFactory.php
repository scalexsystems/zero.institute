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

use Scalex\Zero\Models\School;

$factory->define(
    School::class,
    function (Faker\Generator $faker) {
        return [
            'name' => $faker->company,
            'slug' => $faker->slug(2),
        ];
    }
);

$factory->define(
    Scalex\Zero\User::class,
    function (Faker\Generator $faker) {
        static $password = 'password';

        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => $password ?: $password = bcrypt('secret'),
            'remember_token' => str_random(10),
            'school_id' => function () {
                return factory(School::class)->create()->id;
            },
        ];
    }
);
