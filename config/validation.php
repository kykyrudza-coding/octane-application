<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Behaviour
    |--------------------------------------------------------------------------
    |
    | Applies to validators created through the container, direct request
    | validation, and FormRequest validation.
    |
    */
    'stop_on_first_failure' => (bool) env('VALIDATION_STOP_ON_FIRST_FAILURE', false),

    /*
    |--------------------------------------------------------------------------
    | Presence Verification
    |--------------------------------------------------------------------------
    |
    | The null driver keeps database-aware rules disabled until the application
    | provides a concrete verifier. The array driver is useful for tests.
    |
    */
    'presence' => [
        'driver'   => env('VALIDATION_PRESENCE_DRIVER', 'null'),
        'verifier' => null,
        'tables'   => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Messages
    |--------------------------------------------------------------------------
    |
    | Messages may be keyed by rule name, for example "required", or by
    | attribute and rule, for example "email.required".
    |
    */
    'messages' => [],

    /*
    |--------------------------------------------------------------------------
    | Attribute Names
    |--------------------------------------------------------------------------
    |
    | Human-readable names used in default validation messages.
    |
    */
    'attributes' => [],
];
