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
    | Debugging
    |--------------------------------------------------------------------------
    |
    | Query logging is useful while developing database features, but should
    | remain disabled in normal runtime paths unless explicitly needed.
    |
    */
    'debug' => [
        'log_queries' => (bool) env('QUERY_LOG', false),
    ],
];
