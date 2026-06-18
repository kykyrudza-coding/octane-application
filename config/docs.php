<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | API Documentation
    |--------------------------------------------------------------------------
    |
    | Defaults for the generated framework API reference exposed by the docs
    | package and the docs:api console command.
    |
    */
    'api' => [
        'enabled' => (bool) env('DOCS_API_ENABLED', true),
        'route'   => env('DOCS_API_ROUTE', '/_octane/api'),
        'source'  => null,
        'output'  => APP_ROOT.'/var/framework/api-docs',
    ],
];
