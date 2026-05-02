<?php

namespace Kernel\Application\Configuration;

use Exception;

/**
 * Class Env
 *
 * A utility class for loading environment variables from a .env file
 * and accessing them globally throughout the application.
 *
 * This class reads key-value pairs from a given .env file and sets them
 * into PHP's environment variables (`$_ENV`, `$_SERVER`, and `putenv`).
 * The variables can then be accessed using the `get` method.
 */
class Env
{
    /**
     * Flag to indicate whether the .env file has been loaded.
     *
     * @var bool
     */
    private static $loaded = false;

    /**
     * Loads environment variables from a specified .env file.
     *
     * This method reads the .env file line by line, ignoring comments
     * (lines starting with '#') and empty lines. It sets the environment
     * variables in `$_ENV`, `$_SERVER`, and via `putenv`.
     *
     * @param  string  $filePath  Path to the .env file.
     *
     * @throws Exception If the .env file is not found at the provided path.
     */
    public static function load(string $filePath): void
    {
        if (! file_exists($filePath)) {
            throw new Exception("Файл .env не найден: {$filePath}");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            [$key, $value] = array_map('trim', explode('=', $line, 2));

            $value = trim($value, "\"'");

            if (! array_key_exists($key, $_ENV) && ! getenv($key)) {
                putenv("{$key}={$value}");
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }

        self::$loaded = true;
    }

    /**
     * Retrieves the value of an environment variable.
     *
     * This method checks for the value in `$_ENV`, then `getenv()`,
     * and finally returns the provided default value if the key is not found.
     *
     * @param  string  $key  The environment variable name.
     * @param  mixed|null  $default  The default value to return if the key is not found.
     * @return mixed The value of the environment variable, or the default value if not found.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? getenv($key) ?? $default;
    }
}
