<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Department;
use Scalex\Zero\Models\Discipline;
use Scalex\Zero\Models\Attachment;
use Faker\Generator;

$factory->define(Course::class, function (Generator $f, array $attributes) {
    $courses = [
        'CH101' => 'Chemistry',
        'EE101'	=> 'Electrical Sciences',
        'MA101' => 'Mathematics',
        'PH101' => 'Physics',
        'CH110' => 'Chemistry Laboratory',
        'PH110'	=> 'Workshop',
        'ME110' => 'Physics Laboratory',
        'ME111' => 'Engineering Drawing',
        'BT101' => 'Modern Biology',
        'CS101'	=> 'Introduction to Computing',
        'ME101'	=> 'Engineering Mechanics',
        'CS110'	=> 'Computing Laboratory',
        'EE102'	=> 'Basic Electronics Laboratory',
        'SA102'	=> 'Physical Training',
    ];

    $code = $f->randomElement(array_keys($courses));

    $attributes['school_id'] = $attributes['school_id'] ?? factory(School::class)->create()->id;

    return [
        'name' => $courses[$code],
        'code' => $code,
        'description' => $f->paragraph,

        'school_id' => $attributes['school_id'],
        'department_id' => function () use ($attributes) {
            return factory(Department::class)
                    ->create(array_only($attributes, ['school_id']))
                    ->id;
        },
        'discipline_id' => function () use ($attributes) {
            return factory(Discipline::class)
                    ->create(array_only($attributes, ['school_id']))
                    ->id;
        },
    ];
});
