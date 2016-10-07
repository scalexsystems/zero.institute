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
    Action::UPDATE_SCHOOL => [
        'name' => 'Update school information',
        'description' => 'Allow user to update school name, address and other information.',
    ],
    Action::READ_SCHOOL_PRIVATE_INFO => [
        'name' => 'View private school information',
        'description' => '',
    ],
];
