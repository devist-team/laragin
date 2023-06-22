<?php

return [
    'prefix' => 'api/laragin',

    'strategies' => [
        'otp',
    ],

    'cache' => env('CACHE_DRIVER', 'file'),

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
