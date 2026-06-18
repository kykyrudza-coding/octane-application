<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | Supported drivers are bcrypt and argon2. The current support provider
    | reads this driver value when resolving the framework hasher contract.
    |
    */
    'driver' => env('HASH_DRIVER', 'bcrypt'),

    /*
    |--------------------------------------------------------------------------
    | Bcrypt Options
    |--------------------------------------------------------------------------
    |
    | Higher rounds increase CPU cost. Keep local values practical and raise
    | production values only after measuring request latency.
    |
    */
    'bcrypt' => [
        'rounds' => (int) env('BCRYPT_ROUNDS', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Argon2 Options
    |--------------------------------------------------------------------------
    |
    | These options are reserved for Argon2id hashing configuration.
    |
    */
    'argon2' => [
        'memory'  => (int) env('ARGON2_MEMORY', 65536),
        'time'    => (int) env('ARGON2_TIME', 4),
        'threads' => (int) env('ARGON2_THREADS', 1),
    ],
];
