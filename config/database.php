<?php

return [

   'default' => 'SQL_SSO',
   'migrations' => 'migrations',

   'connections' => [
        'SQL_SSO' => [
            'driver'   => 'sqlsrv',
            'host'     => env('DB_HOST', '0.0.0.0'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => env('DB_CHARSET', 'utf8'),
            'prefix'   => env('DB_PREFIX', ''),
        ],
        'SQL_SIMRS' => [
            'driver'   => 'sqlsrv',
            'host'     => env('DB_HOST', '0.0.0.0'),
            'database' => env('DB_DATABASE_DUA', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => env('DB_CHARSET', 'utf8'),
            'prefix'   => env('DB_PREFIX', ''),
        ],
        'SQL_ABSEN' => [
            'driver'   => 'sqlsrv',
            'host'     => env('DB_HOST', '0.0.0.0'),
            'database' => env('DB_DATABASE_DUA', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => env('DB_CHARSET', 'utf8'),
            'prefix'   => env('DB_PREFIX', ''),
        ],
    ],
];
