<?php

declare(strict_types=1);

use Horizon\Http\Middleware\ConvertEmptyStringsToNull;
use Horizon\Http\Middleware\TrimStrings;
use Horizon\Http\Middleware\ValidatePostSize;

return [

    /*
    |--------------------------------------------------------------------------
    | Development Server
    |--------------------------------------------------------------------------
    |
    | Defaults for the built-in PHP development server command. Command line
    | arguments may still override these values.
    |
    */
    'server' => [
        'host' => env('SERVER_HOST', '127.0.0.1'),
        'port' => (int) env('SERVER_PORT', 8000),
    ],

    /*
    |--------------------------------------------------------------------------
    | Request Normalization
    |--------------------------------------------------------------------------
    |
    | These toggles control the built-in request middleware registered by the
    | HTTP service provider.
    |
    */
    'requests' => [
        'trim_strings'                  => (bool) env('HTTP_TRIM_STRINGS', true),
        'convert_empty_strings_to_null' => (bool) env('HTTP_EMPTY_STRINGS_TO_NULL', true),
        'max_post_size_validation'      => (bool) env('HTTP_VALIDATE_POST_SIZE', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware Groups
    |--------------------------------------------------------------------------
    |
    | Add application middleware classes to the global, web, or API groups.
    | Built-in request normalization middleware is added from the toggles above.
    |
    */
    'middleware' => [
        'global' => [
            // ConvertEmptyStringsToNull::class,
            // TrimStrings::class,
        ],

        'web' => [
            // ValidatePostSize::class,
        ],

        'api' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Responses
    |--------------------------------------------------------------------------
    |
    | JSON flags used by the response factory when creating JsonResponse
    | instances.
    |
    */
    'responses' => [
        'json_flags' => JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES,
    ],
];
