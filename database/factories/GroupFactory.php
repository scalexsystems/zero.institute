<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Scalex\Zero\Models\Group::class, function (Faker\Generator $f) {
    return [
        'name' => $f->word,
        'description' => $f->paragraph,
        'private' => false,
        'school_id' => function () {
            return factory(Scalex\Zero\Models\School::class)->create()->id;
        },
        'owner_id' => function () {
            return factory(Scalex\Zero\User::class)->create()->id;
        },
    ];
});
