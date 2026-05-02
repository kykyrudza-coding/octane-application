<?php

namespace Kernel\Application\DataBase\DB\DataBaseConnection;

use PDOException;

/**
 * Class MySQLConnectionParams
 *
 * This class implements the DataBaseConnectionParamsInterface for MySQL database connections.
 * It manages the connection parameters specific to MySQL, including the host, username, password,
 * and database name. It generates the correct connection string for PDO and provides methods
 * to retrieve the necessary credentials for connecting to the database.
 */
class MySQLConnectionParams implements DataBaseConnectionParamsInterface
{
    /**
     * @var string The hostname of the MySQL server
     */
    private string $host;

    /**
     * @var string The username for connecting to the MySQL database
     */
    private string $user;

    /**
     * @var string The password for the MySQL user
     */
    private string $password;

    /**
     * @var string The name of the MySQL database
     */
    private string $database;

    /**
     * MySQLConnectionParams constructor.
     *
     * Initializes the connection parameters based on the provided driver and configuration array.
     *
     * @param  string  $driver  The name of the database driver (e.g., 'mysql')
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
     * Retrieves the connection string for MySQL.
     *
     * @return string The MySQL connection string, including the host, database, and charset
     */
    public function getConnectionString(): string
    {
        return "mysql:host=$this->host;dbname=$this->database;charset=utf8";
    }

    /**
     * Retrieves the username for the MySQL connection.
     *
     * @return string The username for the MySQL connection
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * Retrieves the password for the MySQL connection.
     *
     * @return string The password for the MySQL connection
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
