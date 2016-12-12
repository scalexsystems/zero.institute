<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */


$factory->define(Scalex\Zero\Models\Discipline::class, function (Faker\Generator $f, array $attributes) {
    $disciplines = [
        'B.Tech.' => 'Bachelors of Technology',
        'M.Tech.' => 'Masters of Technology',
        'B.S.' => 'Bachelor of Science',
        'M.S.' => 'Masters of Science',
        'B.E.' => 'Bachelors of Engineering',
        'M.E.' => 'Masters of Engineering',
    ];

    $code = $f->randomElement(array_keys($disciplines));
    $name = $disciplines[$code];

    return [
        'name' => $name,
        'short_name' => $code,
        'school_id' => function () use ($attributes) {
            return factory(Scalex\Zereo\Models\School::class)->create()->id;
        },
    ];
});
