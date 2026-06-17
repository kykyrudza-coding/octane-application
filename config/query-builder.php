<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection
    |--------------------------------------------------------------------------
    |
    | The QueryBuilder uses this connection when no explicit connection is
    | selected. The value should match a connection from config/database.php.
    |
    */
    'default_connection' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Fetch Mode
    |--------------------------------------------------------------------------
    |
    | Controls how PDO returns rows before the framework wraps them into
    | QueryBuilder result objects.
    |
    */
    'fetch_mode' => PDO::FETCH_ASSOC,

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | Default pagination values used by QueryBuilder pagination helpers when
    | the caller does not provide an explicit page size.
    |
    */
    'pagination' => [
        'per_page' => 15,
    ],

    /*
    |--------------------------------------------------------------------------
    | Debugging
    |--------------------------------------------------------------------------
    |
    | Query logging is useful while developing database features, but should
    | remain disabled in normal runtime paths unless explicitly needed.
    |
    */
    'debug' => [
        'log_queries' => env('QUERY_LOG', false),
    ],
];
