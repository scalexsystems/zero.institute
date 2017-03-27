<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */


$factory->define(Scalex\Zero\Models\Semester::class, function (Faker\Generator $f, array $attributes) {
    return [
    'name' => $f->name,
        'school_id' => function () use ($attributes) {
            return factory(Scalex\Zero\Models\School::class)->create()->id;
        },
    ];
});
