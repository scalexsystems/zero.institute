<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Scalex\Zero\Models\Guardian::class, function (Faker\Generator $f, array $attributes) {
    return [
        'first_name' => $f->firstName,
        'last_name' => $f->optional()->lastName,
        'school_id' => function () {
            return factory(Scalex\Zero\Models\School::class)->create()->id;
        },
    ];
});
