<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Route Files
    |--------------------------------------------------------------------------
    |
    | These files are loaded by the framework during bootstrap when
    | boot/app.php does not provide explicit route files.
    |
    */
    'files' => [
        'web' => APP_ROOT.'/routes/web.php',
        'api' => APP_ROOT.'/routes/api.php',
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Groups
    |--------------------------------------------------------------------------
    |
    | Group attributes are applied while loading each conventional route file.
    | Middleware class lists belong to config/http.php.
    |
    */
    'groups' => [
        'web' => [
            'prefix' => '',
            'name'   => '',
        ],

        'api' => [
            'prefix' => 'api',
            'name'   => 'api.',
        ],
    ],
];
