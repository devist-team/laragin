<?php

return [
    'prefix' => 'api/laragin',

    'strategies' => [
        'otp',
    ],

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
