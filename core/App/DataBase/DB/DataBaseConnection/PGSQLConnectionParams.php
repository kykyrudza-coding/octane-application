<?php

namespace Kernel\Application\DataBase\DB\DataBaseConnection;

use PDOException;

/**
 * Class PGSQLConnectionParams
 *
 * This class implements the DataBaseConnectionParamsInterface for PostgresSQL database connections.
 * It handles the connection parameters specific to PostgresSQL, including the host, username, password,
 * and database name. It generates the correct connection string for PDO and provides methods
 * to retrieve the necessary credentials for connecting to the database.
 */
class PGSQLConnectionParams implements DataBaseConnectionParamsInterface
{
    /**
     * @var string The hostname of the PostgresSQL server
     */
    private string $host;

    /**
     * @var string The username for connecting to the PostgresSQL database
     */
    private string $user;

    /**
     * @var string The password for the PostgresSQL user
     */
    private string $password;

    /**
     * @var string The name of the PostgresSQL database
     */
    private string $database;

    /**
     * PGSQLConnectionParams constructor.
     *
     * Initializes the connection parameters based on the provided driver and configuration array.
     *
     * @param  string  $driver  The name of the database driver (e.g., 'pgsql')
     * @param  array  $dbConfig  An associative array containing the database connection settings:
     *                           'host', 'username', 'password', 'database'
     *
     * @throws PDOException If any required configuration is missing (host, user, or password)
     */
    public function __construct(string $driver, array $dbConfig)
    {
        $this->host = $dbConfig['host'] ?? '';
        $this->user = $dbConfig['username'] ?? '';
        $this->password = $dbConfig['password'] ?? '';
        $this->database = $dbConfig['database'] ?? '';

        if (empty($this->host) || empty($this->user) || empty($this->password)) {
            throw new PDOException("For $driver, host, user, and password are required.");
        }
    }

    /**
     * Retrieves the connection string for PostgresSQL.
     *
     * @return string The PostgresSQL connection string, including the host and database name
     */
    public function getConnectionString(): string
    {
        return "pgsql:host=$this->host;dbname=$this->database";
    }

    /**
     * Retrieves the username for the PostgresSQL connection.
     *
     * @return string The username for the PostgresSQL connection
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * Retrieves the password for the PostgresSQL connection.
     *
     * @return string The password for the PostgresSQL connection
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
