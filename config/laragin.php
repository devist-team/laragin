<?php

return [
    'prefix' => 'api/laragin',

    'strategies' => [
        'otp',
        'password',
        'register',
    ],

    'cache' => env('CACHE_DRIVER', 'file'),

    'expose' => env('APP_DEBUG', 'false'),

    'drivers' => [
        'otp'      => [
            'lifetime'   => 2 * 60,
            'digits'     => 4,
            'identifier' => 'mobile',
            'models'     => [

            ],
            'channels'   => [
                'email',
            ],
        ],
        'password' => [
            'identifier'        => 'mobile',
            'restricted_update' => false,
        ],
        'register' => [
            'identifier' => 'mobile',

            'login'    => true,
            'channels' => [

            ],
        ],
    ],
];
