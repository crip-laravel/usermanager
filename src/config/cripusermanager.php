<?php

return [

    'pretend' => [
        'enabled' => false,
        'options' => [
            'is' => true,
            'can' => true,
        ]
    ],
    'models' => [
        'role' => \Crip\UserManager\Models\Role::class,
        'permission' => \Crip\UserManager\Models\Perm::class,
    ]

];