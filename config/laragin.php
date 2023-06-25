<?php

return [
    'prefix' => 'api/laragin',

    'strategies' => [
        'otp',
    ],

    'cache' => env('CACHE_DRIVER', 'file'),

    'expose' => env('APP_DEBUG', 'false'),

    'drivers' => [
        'otp' => [
            'lifetime'   => 2 * 60,
            'digits'     => 4,
            'identifier' => 'mobile',
            'models'     => [

            ],
            'channels'   => [

            ],
        ],
    ],
];
