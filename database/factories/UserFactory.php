<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Scalex\Zero\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
        'verification_token' => str_random(10),
        'school_id' => function () {
            return factory(Scalex\Zero\Models\School::class)->create()->id;
        },
    ];
});
