<?php

return [
    'process' => [
        'specie' => [
            'dog' => 'dog',
            'cat' => 'cat',
        ],

        'status' => [
            'approving' => 'approving',
            'waiting_godfather' => 'waiting_godfather',
            'waiting_capture' => 'waiting_capture',
            'open' => 'open',
            'closed' => 'closed',
            'archived' => 'archived'
        ]
    ],

    'territory' => [
        'levels' => [
            1 => 'district',
            2 => 'county',
            3 => 'parish'
        ]
    ],

    'vet' => [
        'status' => [
            'active' => 'active',
            'inactive' => 'inactive'
        ]
    ],

    'user' => [
        'status' => [
            1 => 'active',
            0 => 'inactive'
        ],
        'roles' => [
            1 => 'admin', 
            2 => 'volunteer',
            3 => 'FAT'
        ],
        'permissions' => [
            1 => 'processes',
            2 => 'counters',
            3 => 'adoptions',
            4 => 'accountancy',
            5 => 'website',
            6 => 'store',
            7 => 'friend card',
            8 => 'vets',
            9 => 'protocols',
            10 => 'council'
        ]
    ]
];