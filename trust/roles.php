<?php

/*
|--------------------------------------------------------------------------
| Trust Roles
|--------------------------------------------------------------------------
|
| This file is where you may define your roles.
|
*/

return [
    'admin' => [
        'name' => 'Administrator',
        'description' => 'These users would have every available permission.',
        'permissions' => ['*'],
    ],
    'course-manager' => [
        'name' => 'Course Manager',
        'description' => 'add courses and assign teachers/coordinator',
        'permissions' => ['course.*'],
    ],
];