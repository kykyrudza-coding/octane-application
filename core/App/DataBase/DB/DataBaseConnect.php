<?php

namespace Kernel\Application\DataBase\DB;

use Kernel\Application\Configuration\Config;
use Kernel\Application\DataBase\DB\DataBaseConfig\DataBaseConfig;
use Kernel\Application\DataBase\DB\DataBaseConfig\DataBaseConfigInterface;
use Kernel\Application\DataBase\DB\DataBaseConnection\DataBaseConnectionParamsInterface;
use Kernel\Application\DataBase\DB\DataBaseConnection\MySQLConnectionParams;
use Kernel\Application\DataBase\DB\DataBaseConnection\PGSQLConnectionParams;
use Kernel\Application\DataBase\DB\DataBaseConnection\SQLiteConnectionParams;
use PDO;
use PDOException;

/**
 * Class DataBaseConnect
 *
 * This class handles the database connection for different database drivers
 * such as MySQL, PostgresSQL, and SQLite. It uses the PDO extension to connect
 * to the database and sets appropriate connection parameters based on the
 * configuration.
 */
class DataBaseConnect
{
    /**
     * @var DataBaseConfigInterface Database configuration object
     */
    private DataBaseConfigInterface $config;

    /**
     * @var DataBaseConnectionParamsInterface Connection parameters for the database
     */
    private DataBaseConnectionParamsInterface $connectionParams;

    /**
     * DataBaseConnect constructor.
     *
     * Initializes the database connection configuration and connection parameters.
     *
     * @param  Config  $config  Configuration object containing database connection settings
     */
    public function __construct(Config $config)
    {
        $this->config = new DataBaseConfig($config);
        $this->connectionParams = $this->createConnectionParams();
    }

    /**
     * Creates the appropriate connection parameters based on the database driver.
     *
     * @return MySQLConnectionParams|PGSQLConnectionParams|SQLiteConnectionParams The connection parameters for the database driver
     *
     * @throws PDOException If an unsupported database driver is specified
     */
    private function createConnectionParams(): MySQLConnectionParams|PGSQLConnectionParams|SQLiteConnectionParams
    {
        $driver = $this->config->getDriver();
        $driverConfig = $this->config->getDriverConfig($driver);

        return match ($driver) {
            'mysql' => new MySQLConnectionParams($driver, $driverConfig),
            'pgsql' => new PGSQLConnectionParams($driver, $driverConfig),
            'sqlite' => new SQLiteConnectionParams($driver, $driverConfig),
            default => throw new PDOException("Unsupported database driver: $driver"),
        };
    }

    /**
     * Establishes a connection to the database using PDO.
     *
     * @return PDO The PDO instance representing the database connection
     *
     * @throws PDOException If the connection fails
     */
    public function connect(): PDO
    {
        $this->connectionParams = $this->createConnectionParams();
        $dsn = $this->connectionParams->getConnectionString();
        $user = $this->connectionParams->getUser();
        $password = $this->connectionParams->getPassword();

        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (PDOException $e) {
            throw new PDOException('Connection failed: '.$e->getMessage());
        }
    }
}
