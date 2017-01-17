<?php

return [
    'models' => [
        'user' => Scalex\Zero\User::class,
        'role' => Scalex\Zero\Models\Role::class,
        'permission' => Znck\Trust\Models\Permission::class,
    ],
    'permissions' => 'trust/permissions.php',
    'roles' => 'trust/roles.php',
];
