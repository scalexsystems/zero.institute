<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Scalex\Zero\Models\Student::class, function (Faker\Generator $f, array $attributes) {
    return [
        'first_name' => $f->firstName,
        'middle_name' => $f->optional()->lastName,
        'last_name' => $f->lastName,
        'date_of_birth' => $f->date(),
        'gender' => $f->randomElement(['female', 'male', 'other']),
        'uid' => $f->unique()->numberBetween(0, 1000000),
        'date_of_admission' => $f->date(),
        'department_id' => function () use ($attributes) {
            return factory(Scalex\Zero\Models\Department::class)->create(array_only($attributes, 'school_id'))->id;
        }
        ,
        'discipline_id' => function () use ($attributes) {
            return factory(Scalex\Zero\Models\Discipline::class)->create(array_only($attributes, 'school_id'))->id;
        },
        'religion' => $f->optional()->word,
        'language' => $f->optional()->languageCode,
        'additional' => ['aadhar_number' => $f->optional()->numerify('############')],
        'passport' => $f->optional()->numerify('######'),
        'address_id' => function () {
            return factory(Scalex\Zero\Models\Geo\Address::class)->create()->id;
        },
        'father_id' => function () use ($attributes) {
            return factory(Scalex\Zero\Models\Guardian::class)->create(array_only($attributes, 'school_id'))->id;
        },
        'mother_id' => function () use ($attributes) {
            return factory(Scalex\Zero\Models\Guardian::class)->create(array_only($attributes, 'school_id'))->id;
        },
        'is_disabled' => $f->boolean(),
        'disability' => $f->word,
        'disease' => $f->optional()->word,
        'visible_marks' => $f->optional()->sentence,
        'medical_remarks' => $f->optional()->realText(),
        'school_id' => function () {
            return factory(Scalex\Zero\Models\School::class)->create()->id;
        },
    ];
});
