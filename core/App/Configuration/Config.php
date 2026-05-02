<?php

namespace Kernel\Application\Configuration;

use Exception;

/**
 * Class Config
 *
 * A configuration handler that allows accessing and managing application settings.
 * It supports nested keys using dot notation.
 */
class Config
{
    /**
     * The configuration data.
     */
    private array $config = [];

    /**
     * Constructor.
     *
     * Initializes the configuration with the provided array.
     *
     * @param  array  $config  The initial configuration data.
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Retrieves a configuration value by its key.
     *
     * Supports dot notation for accessing nested keys.
     *
     * @param  string  $key  The configuration key.
     * @param  mixed|null  $default  The default value to return if the key does not exist.
     * @return mixed The configuration value or the default value.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);
        $value = $this->config;

        foreach ($keys as $keyPart) {
            if (isset($value[$keyPart])) {
                $value = $value[$keyPart];
            } else {
                return $default;
            }
        }

        return $value;
    }

    /**
     * Retrieves all configuration data.
     *
     * @return array The entire configuration array.
     */
    public function all(): array
    {
        return $this->config;
    }

    /**
     * Loads configuration data from a file.
     *
     * The file must return an array of configuration settings.
     *
     * @param  string  $filePath  The path to the configuration file.
     *
     * @throws Exception If the file does not exist.
     */
    public function loadFromFile(string $filePath): void
    {
        if (file_exists($filePath)) {
            $this->config = require $filePath;
        } else {
            throw new Exception("Configuration file does not exist: $filePath");
        }
    }
}
