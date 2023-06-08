<?php

return [
    'prefix' => 'api/laragin',

    'strategies' => [
        'otp',
    ],

    'drivers' => [
        'otp' => [
            'identifier' => 'mobile',
            'models'     => [

            ],
            'channels'   => [

            ],
        ],
    ],
];
