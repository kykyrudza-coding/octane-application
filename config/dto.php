<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Metadata
    |--------------------------------------------------------------------------
    |
    | DTO metadata is built from constructor parameters, public properties,
    | PHP types, and DTO attributes.
    |
    */
    'metadata' => [
        'cache' => [
            'enabled' => (bool) env('DTO_METADATA_CACHE', false),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Mapping
    |--------------------------------------------------------------------------
    |
    | Mapping defines how input payloads are converted into DTO instances.
    | unknown_fields supports "ignore" and "throw"; missing_fields supports
    | "throw" and "null".
    |
    */
    'mapping' => [
        'strict'         => (bool) env('DTO_STRICT_MAPPING', true),
        'unknown_fields' => env('DTO_UNKNOWN_FIELDS', 'ignore'),
        'missing_fields' => env('DTO_MISSING_FIELDS', 'throw'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Serialization
    |--------------------------------------------------------------------------
    |
    | Controls how DTOs are converted back to arrays or JSON.
    |
    */
    'serialization' => [
        'include_null' => (bool) env('DTO_INCLUDE_NULL', true),
        'json_flags'   => JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES,
    ],
];
