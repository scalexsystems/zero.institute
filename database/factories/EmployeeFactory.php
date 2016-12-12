<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Scalex\Zero\Models\Employee::class, function (Faker\Generator $f, array $attributes) {
    $is_disable = $f->boolean();

    return [
        'first_name' => $f->firstName,
        'last_name' => $f->lastName,
        'middle_name' => $f->optional()->name,
        'date_of_birth' => $f->date(),
        'gender' => $f->randomElement(['male', 'female', 'other']),
        'uid' => $f->unique()->numberBetween(0, 1000000),
        'date_of_joining' => $f->date(),
        'job_title' => $f->title,
        'department_id' => function () use ($attributes) {
            return factory(Scalex\Zero\Models\Department::class, $attributes)->create()->id;
        },
        'nationality' => $f->name,
        'category' => $f->randomElement(['gen', 'obc', 'sc', 'st', 'ot']),
        'passport' => $f->optional()->word,
        'religion' => $f->optional()->word,
        'language' => $f->optional()->word,
        'address_id' => function () {
            return factory(Scalex\Zero\Models\Geo\Address::class)->create()->id;
        },
        'bank' => $f->optional()->word,
        'beneficiary_name' => $f->optional()->word,
        'bank_account_number' => $f->optional()->word,
        'ifsc_code' => $f->optional()->word,
        'is_disabled' => $is_disable,
        'disability' => $is_disable ? $f->word : null,
        'disease' => $f->optional()->word,
        'allergy' => $f->optional()->word,
        'visible_marks' => $f->optional()->word,
        'medical_remarks' => 'max:65536',
        'school_id' => function () {
            return factory(Scalex\Zero\Models\School::class)->create()->id;
        },
    ];
});
