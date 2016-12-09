<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Scalex\Zero\Models\Department::class, function (Faker\Generator $f, array $attributes) {
    $departments = [
        'CSE' => 'Computer Science & Engineering',
        'EEE' => 'Electrical & Electonics Engineering',
        'ECE' => 'Electrical & Communication Engineering',
        'MC'  => 'Mathematics & Computation',
        'PH'  => 'Physics',
        'CH'  => 'Chemistry',
        'HSS' => 'Humaneties and Social Science',
        'CE'  => 'Chemical Engineering',
        'CL'  => 'Civil Engineerging',
        'BT'  => 'BioTechnology',
        'DS'  => 'Design',
        1 => 'Maintenance Department',
        2 => 'Finance Department',
        3 => 'Academic Board',
        4 => 'Student Affairs Board',
        5 => 'Hostel Welfare Board',
    ];

    $code = $f->randomElement(array_keys($departments));
    $name = $departments[$code];
    $academic = is_string($code);
    $code = is_string($code) ? $code : null;

    return [
        'name' => $name,
        'short_name' => $code,
        'academic' => $academic,
        'school_id' => function () {
            return factory(Scalex\Zero\Models\School::class)->create()->id;
        },
    ];
});
