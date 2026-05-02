<?php

return [
    'name' => env('APP_NAME', 'Octane'),
    'debug' => env('APP_DEBUG'),
    'url' => env('APP_URL'),
    'timezone' => 'UTC',
    'key' => env('APP_KEY'),
    'database' => [
        'driver' => env('DB_DRIVER', 'mysql'),
        'mysql' => [
            'host' => env('DB_HOST', '127.0.0.1'),
            'username' => env('DB_USERNAME', 'octane'),
            'password' => env('DB_PASSWORD', ''),
            'database' => env('DB_DATABASE', 'octane'),
        ],
        'pgsql' => [
            'host' => env('DB_HOST', '127.0.0.1'),
            'username' => env('DB_USERNAME', 'octane'),
            'password' => env('DB_PASSWORD', ''),
            'database' => env('DB_DATABASE', 'octane'),
        ],
        'sqlite' => [
            'sqlite_path' => env('DB_SQLITE_PATH', app_path('database/database.sqlite')),
        ],
    ],
];
