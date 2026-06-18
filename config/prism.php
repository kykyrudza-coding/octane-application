<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | View Paths
    |--------------------------------------------------------------------------
    |
    | Prism resolves dot-notated views from the application UI views path.
    |
    */
    'views' => [
        'path'       => APP_ROOT.'/ui/views',
        'extensions' => ['.prism.php', '.php', '.html'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled Templates
    |--------------------------------------------------------------------------
    |
    | Compiled Prism templates live in the application cache directory.
    |
    */
    'compiler' => [
        'cache' => [
            'enabled' => (bool) env('PRISM_CACHE', true),
            'path'    => APP_ROOT.'/var/cache/prism',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Components
    |--------------------------------------------------------------------------
    |
    | Component aliases may be registered here once component registration is
    | driven by configuration.
    |
    */
    'components' => [
        'aliases' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Directives
    |--------------------------------------------------------------------------
    |
    | Custom directive classes may be registered here in future versions.
    |
    */
    'directives' => [],
];
