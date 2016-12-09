<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Scalex\Zero\Models\Group::class, function (Faker\Generator $f, array $attributes) {
    return [
        'name' => $f->word,
        'description' => $f->paragraph,
        'private' => false,
        'school_id' => function () {
            return factory(Scalex\Zero\Models\School::class)->create()->id;
        },
        'owner_id' => function () use ($attributes) {
            return factory(Scalex\Zero\User::class)->create(array_only($attributes, 'school_id'))->id;
        },
    ];
});
