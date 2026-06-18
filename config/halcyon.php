<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Metadata Cache
    |--------------------------------------------------------------------------
    |
    | Controls whether Halcyon caches parsed model metadata. In production
    | this should be enabled for performance. In development disable it
    | so metadata is always re-parsed on every request.
    |
    */

    'metadata' => [
        'cache' => [
            'enabled' => (bool) env('HALCYON_METADATA_CACHE', false),
        ],
    ],
];