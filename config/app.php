<?php

declare(strict_types=1);

use Horizon\Arch\Application;

return [
    /*
    |--------------------------------------------------------------------------
    | Application Identity
    |--------------------------------------------------------------------------
    |
    | These values describe the running application and may be used by
    | error pages, console commands, generated metadata, and diagnostics.
    |
    */
    'name' => env('APP_NAME'),
    'version' => Application::version(),

    /*
    |--------------------------------------------------------------------------
    | Runtime Behaviour
    |--------------------------------------------------------------------------
    |
    | Debug mode controls how much internal information the framework may
    | expose during development. Keep it disabled outside local environments.
    |
    */
    'debug' => '',

    /*
    |--------------------------------------------------------------------------
    | Public URL
    |--------------------------------------------------------------------------
    |
    | The canonical URL for this application. Framework helpers may use this
    | value when generating absolute links or diagnostics.
    |
    */
    'url' => '',

    /*
    |--------------------------------------------------------------------------
    | Localization
    |--------------------------------------------------------------------------
    |
    | The default timezone used by date helpers, logs, and application code
    | that relies on PHP date/time functions.
    |
    */
    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | The application key is reserved for encrypted cookies, signed values,
    | tokens, and other framework features that need a stable secret.
    |
    */
    'key' => '',
];
