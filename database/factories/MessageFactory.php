<?php /** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Scalex\Zero\Models\Message::class, function (Faker\Generator $f, array $attributes) {
    return [
        'type' => 'text',
        'content' => $f->paragraph,
        'receiver_type' => 'user',
        'receiver_id' => function () {
            return factory(Scalex\Zero\User::class)->create()->id;
        },
        'sender_id' => function () use ($attributes) {
            return factory(Scalex\Zero\User::class)->create(array_only($attributes, 'school_id'))->id;
        },
    ];
});
