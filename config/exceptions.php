<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Debug Rendering
    |--------------------------------------------------------------------------
    |
    | Controls whether rendered exceptions expose internal information.
    |
    */
    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Reporting
    |--------------------------------------------------------------------------
    |
    | Exceptions listed in ignore will not be reported by the exception
    | handler.
    |
    */
    'reporting' => [
        'ignore' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rendering
    |--------------------------------------------------------------------------
    |
    | default supports auto, html, json, and console.
    |
    */
    'rendering' => [
        'default' => env('EXCEPTION_RENDERER', 'auto'),

        'json' => [
            'pretty' => (bool) env('EXCEPTION_JSON_PRETTY', false),
        ],

        'views' => [
            'path' => null,
        ],
    ],
];
