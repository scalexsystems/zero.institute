<?php

use Scalex\Zero\Action;

/*
|--------------------------------------------------------------------------
| Trust Permissions
|--------------------------------------------------------------------------
|
| This file is where you may define your user permissions.
|
*/

return [
    /*
     * School
     */
    Action::UPDATE_SCHOOL => [
        'name' => 'Update School Information',
        'description' => 'Allow user to update school information.',
    ],
    Action::VIEW_PRIVATE_SCHOOL_INFO => [
        'name' => 'View private school information',
        'description' => '',
    ],
    Action::UPDATE_DEPARTMENT => [
        'name' => 'Create/Update Department',
        'description' => 'Allow user to create or update departments.',
    ],
    Action::UPDATE_DISCIPLINE => [
        'name' => 'Create/Update Discipline',
        'description' => 'Allow user to create or update disciplines.',
    ],

    /*
     * People
     */
    Action::PEOPLE => [
        'name' => 'People',
        'description' => 'Allow user to access people directory.',
    ],
    Action::MANAGE_PEOPLE => [
        'name' => 'Manage Accounts',
        'description' => 'Allow user to accept/reject account requests.',
    ],
    Action::VIEW_STUDENT => [
        'name' => 'View Student Profile',
        'description' => 'Allow user to see detailed student profile.',
    ],
    Action::VIEW_TEACHER => [
        'name' => 'View Teacher Profile',
        'description' => 'Allow user to see detailed teacher profile.',
    ],
    Action::VIEW_EMPLOYEE => [
        'name' => 'View Employee Profile',
        'description' => 'Allow user to see detailed employee profile.',
    ],
];
