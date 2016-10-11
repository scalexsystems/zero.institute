<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

use Scalex\Zero\Models\Department;
use Scalex\Zero\Models\Discipline;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Models\Geo\Address;
use Scalex\Zero\Models\Geo\City;
use Scalex\Zero\Models\Geo\Country;
use Scalex\Zero\Models\Geo\State;
use Scalex\Zero\Models\Guardian;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
        'verification_token' => str_random(10),
        'school_id' => function () {
            return factory(School::class)->create()->id;
        },
    ];
});

/**
 * School Seeder.
 */
$factory->define(School::class, function (Faker\Generator $f) {
    return [
        'name' => $f->company.' School',
        'slug' => $f->slug(2),
        'website' => $f->url,
        'email' => $f->email,
        'phone' => $f->numerify('+918473######'),
        'fax' => $f->numerify('+918473######'),
        'medium' => $f->randomElement(['en', 'hi']),
        'institute_type' => 'School',
        'timezone' => $f->timezone,
        'verified' => true,
        'university' => 'o',
        'address_id' => function () {
            return factory(Address::class)->create()->id;
        },
    ];
});
$factory->define(Department::class, function (Faker\Generator $f, array $attributes) {
    return [
        'name' => 'Class '.$f->randomDigit,
        'academic' => $f->boolean(),
        'school_id' => $attributes['school_id'] ?? function () use ($attributes) {
                return factory(School::class)->create()->id;
            },
    ];
});
$factory->define(Discipline::class, function (Faker\Generator $f, array $attributes) {
    return [
        'name' => $f->word,
        'school_id' => $attributes['school_id'] ?? function () use ($attributes) {
                return factory(School::class)->create()->id;
            },
    ];
});


/**
 * People Seeder
 */
$factory->define(Guardian::class, function (Faker\Generator $f, array $attributes) {
    return [
        'first_name' => $f->firstName,
        'last_name' => $f->optional()->lastName,
        'school_id' => $attributes['school_id'] ?? function () {
                return factory(School::class)->create()->id;
            },
    ];
});

$factory->define(Student::class, function (Faker\Generator $f, array $attributes) {
    return [
        'first_name' => $f->firstName,
        'middle_name' => $f->optional()->lastName,
        'last_name' => $f->lastName,
        'date_of_birth' => $f->date(),
        'gender' => $f->randomElement(['female', 'male', 'other']),
        'uid' => $f->unique()->numberBetween(0, 1000000),
        'date_of_admission' => $f->date(),
        'department_id' => function () use ($attributes) {
            return factory(Department::class)->create(array_only($attributes, 'school_id'))->id;
        }
        ,
        'discipline_id' => function () use ($attributes) {
            return factory(Discipline::class)->create(array_only($attributes, 'school_id'))->id;
        },
        'religion' => $f->optional()->word,
        'language' => $f->optional()->languageCode,
        'additional' => ['aadhar_number' => $f->optional()->numerify('############')],
        'passport' => $f->optional()->numerify('######'),
        'address_id' => function () {
            return factory(Address::class)->create()->id;
        },
        'father_id' => function () use ($attributes) {
            return factory(Guardian::class)->create(array_only($attributes, 'school_id'))->id;
        },
        'mother_id' => function () use ($attributes) {
            return factory(Guardian::class)->create(array_only($attributes, 'school_id'))->id;
        },
        'is_disabled' => $f->boolean(),
        'disability' => $f->word,
        'disease' => $f->optional()->word,
        'visible_marks' => $f->optional()->sentence,
        'medical_remarks' => $f->optional()->realText(),
        'school_id' => $attributes['school_id'] ?? function () {
                return factory(School::class)->create()->id;
            },
    ];
});
$factory->define(Teacher::class, function (Faker\Generator $f, array $attributes) {
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
            return factory(Department::class)->create(array_only($attributes, 'school_id'))->id;
        },
        'specialization' => $f->word,
        'nationality' => $f->name,
        'passport' => $f->optional()->word,
        'religion' => $f->optional()->word,
        'language' => $f->optional()->word,
        'address_id' => function () {
            return factory(Address::class)->create()->id;
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
            return factory(School::class)->create()->id;
        },
    ];
});
$factory->define(Employee::class, function (Faker\Generator $f, array $attributes) {
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
            return factory(Department::class, $attributes)->create()->id;
        },
        'nationality' => $f->name,
        'category' => $f->randomElement(['gen', 'obc', 'sc', 'st', 'ot']),
        'passport' => $f->optional()->word,
        'religion' => $f->optional()->word,
        'language' => $f->optional()->word,
        'address_id' => function () {
            return factory(Address::class)->create()->id;
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
            return factory(School::class)->create()->id;
        },
    ];
});

/**
 * Others
 */
$factory->define(Country::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->country,
        'code' => $faker->unique()->countryCode,
    ];
});
$factory->define(State::class, function (Faker\Generator $f) {
    if (Country::count() > 10) {
        $country_id = Country::find(rand(1, 10))->id;
    }

    return [
        'name' => $f->state,
        'code' => $f->unique()->stateAbbr,
        'country_id' => $country_id ?? function () {
                return factory(Country::class)->create()->id;
            },
    ];
});
$factory->define(City::class, function (Faker\Generator $f) {
    if (State::count() > 40) {
        $state_id = State::find(rand(1, 40))->id;
    }

    return [
        'name' => $f->city,
        'code' => $f->unique()->countryCode.' '.$f->unique()->countryISOAlpha3,
        'state_id' => $state_id ?? function () {
                return factory(State::class)->create()->id;
            },
    ];
});
$factory->define(Address::class, function (Faker\Generator $f) {
    if (City::count() > 200) {
        $city_id = City::find(rand(1, 200))->id;
    }

    return [
        'address_line1' => $f->streetAddress,
        'address_line2' => $f->streetName,
        'landmark' => $f->optional()->streetSuffix,
        'pin_code' => $f->numerify('######'),
        'phone' => $f->numerify('+918473######'),
        'email' => $f->email,
        'city_id' => $city_id ?? function () {
                return factory(City::class)->create()->id;
            },
    ];
});
