<?php

return [
    'role_structure' => [
        'owner' => [
            'users'    => 'c,r,u,d',
            'post'     => 'c,r,u,d',
            'category' => 'c,r,u,d',
            'tags'     => 'c,r,u,d',
            'actor'    => 'c,r,u,d',
            'setting'  => 'r,u',
            'profile'  => 'r,u',
        ],
        'administrator' => [
        ],
        'admin' => [
        ],
        'user' => [
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
