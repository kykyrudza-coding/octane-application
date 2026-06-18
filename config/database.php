<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Connection
    |--------------------------------------------------------------------------
    |
    | This connection name is used whenever database code asks for the default
    | connection. It must match one of the keys in the connections array below.
    |
    */
    'default_connection' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Each connection describes how Octane should create a PDO-backed database
    | connection. QueryBuilder, migrations, and DB services read these values.
    |
    */
    'connections' => [
        /*
        |--------------------------------------------------------------------------
        | MySQL
        |--------------------------------------------------------------------------
        |
        | The default relational database profile for local and production
        | applications that use MySQL or compatible engines.
        |
        */
        'mysql' => [
            'driver'   => 'mysql',
            'host'     => env('DB_HOST', '127.0.0.1'),
            'port'     => (int) env('DB_PORT', 3306),
            'database' => env('DB_NAME', 'octane'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => 'utf8mb4',
            'options'  => [
                'strict'    => true,
                'timeout'   => 5,
                'reconnect' => true,
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | PostgreSQL
        |--------------------------------------------------------------------------
        |
        | PostgreSQL uses the same common environment variables as MySQL, with
        | PostgreSQL-specific defaults for port, charset, and schema.
        |
        */
        'pgsql' => [
            'driver'   => 'pgsql',
            'host'     => env('DB_HOST', '127.0.0.1'),
            'port'     => (int) env('DB_PORT', 5432),
            'database' => env('DB_NAME', 'octane'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => 'utf8',
            'schema'   => 'public',
            'options'  => [
                'timeout'   => 5,
                'reconnect' => true,
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | SQLite
        |--------------------------------------------------------------------------
        |
        | SQLite is useful for local development, tests, and small embedded
        | applications. The database value points to the SQLite file.
        |
        */
        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => env('DB_NAME', 'database.sqlite'),
            'options'  => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Query Log
    |--------------------------------------------------------------------------
    |
    | Enables query logging and defines the slow query threshold in
    | milliseconds. Keep this disabled unless debugging database behaviour.
    |
    */
    'query_log' => [
        'enabled'        => (bool) env('DB_QUERY_LOG', false),
        'slow_threshold' => (int) env('DB_QUERY_LOG_SLOW_MS', 100),
    ],
];
