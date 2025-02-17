<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\Scalex\Zero\Models\Country::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->country,
        'code' => $faker->unique()->countryCode,
    ];
});
