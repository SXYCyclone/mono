<?php

declare(strict_types=1);

return [
    'cmd' => [
        'user' => [
            'arg' => [
                'user' => 'user',
            ],
            'help' => [
                'desc' => 'Show user info',
                'usage' => 'user <user>',
                'example' => 'user\nuser @user\nuser 123456789',
            ],
        ],

        'avatar' => [
            'arg' => [
                'target' => 'target',
            ],
            'help' => [
                'desc' => 'Show avatar',
                'usage' => 'avatar <target>',
                'example' => 'avatar\navatar guild\navatar @user\navatar 123456789',
            ],
        ],

        'guild' => [
            'help' => [
                'desc' => 'Show guild info',
                'usage' => 'guild',
                'example' => 'guild',
            ],
        ],

        'roles' => [
            'help' => [
                'desc' => 'Show roles',
                'usage' => 'roles',
                'example' => 'roles',
            ],
        ],
    ],
];
