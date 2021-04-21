<?php

return [

   'default' => 'sql_sso',
   'migrations' => 'migrations',

   'connections' => [
        'sql_sso' => [
            'driver'   => 'sqlsrv',
            'host'     => env('DB_HOST', '0.0.0.0'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => env('DB_CHARSET', 'utf8'),
            'prefix'   => env('DB_PREFIX', ''),
        ],
        'sql_simrs' => [
            'driver'   => 'sqlsrv',
            'host'     => env('DB_HOST', '0.0.0.0'),
            'database' => env('DB_DATABASE_DUA', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => env('DB_CHARSET', 'utf8'),
            'prefix'   => env('DB_PREFIX', ''),
        ],
        'sql_absen' => [
            'driver'   => 'sqlsrv',
            'host'     => env('DB_HOST', '0.0.0.0'),
            'database' => env('DB_DATABASE_TIGA', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => env('DB_CHARSET', 'utf8'),
            'prefix'   => env('DB_PREFIX', ''),
        ],
    ],
];
