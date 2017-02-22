<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Scalex\Zero\Models\School::class, function (Faker\Generator $f) {
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
            return factory(\Scalex\Zero\Models\Address::class)->create()->id;
        },
    ];
});
