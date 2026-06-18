<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use Horizon\Arch\Application;

return [
    /*
    |--------------------------------------------------------------------------
    | Application Identity
    |--------------------------------------------------------------------------
    |
    | These values describe the running application and are used by console
    | diagnostics, error rendering, generated metadata, and application code.
    |
    */
    'name'    => env('APP_NAME', 'Octane'),
    'version' => Application::version(),

    /*
    |--------------------------------------------------------------------------
    | Runtime Behaviour
    |--------------------------------------------------------------------------
    |
    | Debug mode controls how much internal information the framework may
    | expose while rendering exceptions.
    |
    */
    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Public URL
    |--------------------------------------------------------------------------
    |
    | The canonical URL for this application. Framework helpers may use this
    | value when generating absolute links or diagnostics.
    |
    */
    'url' => env('APP_URL', 'http://127.0.0.1:8000'),

    /*
    |--------------------------------------------------------------------------
    | Localization
    |--------------------------------------------------------------------------
    |
    | This timezone is applied during bootstrap after configuration is loaded.
    |
    */
    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | Reserved for encrypted cookies, signed values, tokens, and future
    | framework features that require a stable application secret.
    |
    */
    'key' => env('APP_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Application Providers
    |--------------------------------------------------------------------------
    |
    | Providers listed here are loaded in addition to framework package
    | providers discovered from installed components.
    |
    */
    'providers' => [
        AppServiceProvider::class,
    ],
];
