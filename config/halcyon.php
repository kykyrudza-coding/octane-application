<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Metadata
    |--------------------------------------------------------------------------
    |
    | Controls parsed model metadata. The ORM metadata repository reads these
    | values while resolving model metadata.
    |
    */
    'metadata' => [
        'cache' => [
            'enabled' => (bool) env('HALCYON_METADATA_CACHE', false),
            'path'    => APP_ROOT.'/var/cache/halcyon',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    |
    | Morph map aliases may be configured here or in orm.morph_map. The
    | Halcyon provider applies them to the ORM configurator during boot.
    |
    */
    'relations' => [
        'morph_map' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | ORM Configuration
    |--------------------------------------------------------------------------
    |
    | These arrays mirror the Halcyon facade configuration surface and are
    | applied during the Halcyon service provider boot phase.
    |
    */
    'orm' => [
        'observers' => [],
        'scopes'    => [],
        'morph_map' => [],
    ],
];
