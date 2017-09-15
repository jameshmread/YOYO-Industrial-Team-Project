<?php
return [
    //...
    'default' => env('DB_CONNECTION', 'mysql'),
    //...
    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => getenv('DB_HOST', 'localhost'),
            'database'  => getenv('DB_DATABASE', 'homestead'),
            'username'  => getenv('DB_USERNAME', 'homestead'),
            'password'  => getenv('DB_PASSWORD', 'secret'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ]
    ],
    //...
];
