<?php

namespace Kernel\Application\DataBase\DB\DataBaseConfig;

use Kernel\Application\Configuration\Config;
use PDOException;

/**
 * Class DataBaseConfig
 *
 * This class implements the DataBaseConfigInterface and is responsible for handling the database configuration.
 * It retrieves and provides the database driver and driver-specific configuration from a given config object.
 */
class DataBaseConfig implements DataBaseConfigInterface
{
    /**
     * @var array The database configuration settings
     */
    private array $dbConfig;

    /**
     * DataBaseConfig constructor.
     *
     * Initializes the database configuration from the provided Config object.
     *
     * @param  Config  $config  The configuration object that holds the application settings
     *
     * @throws PDOException If the database configuration is missing or invalid
     */
    public function __construct(Config $config)
    {
        $this->dbConfig = $config->get('app.database');

        if (is_null($this->dbConfig)) {
            throw new PDOException('Database configuration is missing.');
        }
    }

    /**
     * Get the database driver.
     *
     * This method returns the database driver (e.g., 'mysql', 'pgsql', 'sqlite') from the configuration.
     * If no driver is specified, it defaults to 'mysql'.
     *
     * @return string The database driver
     */
    public function getDriver(): string
    {
        return $this->dbConfig['driver'] ?? 'mysql';
    }

    /**
     * Get the configuration settings for a specific database driver.
     *
     * This method returns an array of configuration settings for the provided driver.
     * If the configuration for the given driver is not found, it returns an empty array.
     *
     * @param  string  $driver  The name of the database driver (e.g., 'mysql', 'pgsql', 'sqlite')
     * @return array The configuration settings for the specified driver
     */
    public function getDriverConfig(string $driver): array
    {
        return $this->dbConfig[$driver] ?? [];
    }
}
