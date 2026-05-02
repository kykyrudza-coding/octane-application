<?php

namespace Kernel\Application\DataBase\DB\DataBaseConnection;

use PDOException;

/**
 * Class SQLiteConnectionParams
 *
 * This class implements the DataBaseConnectionParamsInterface for SQLite database connections.
 * It handles the connection parameters specific to SQLite, particularly the database file path.
 * It generates the correct connection string for PDO and provides methods for retrieving the credentials,
 * although SQLite does not use username or password in the same way as other databases.
 */
class SQLiteConnectionParams implements DataBaseConnectionParamsInterface
{
    /**
     * @var string The path to the SQLite database file
     */
    private string $database;

    /**
     * SQLiteConnectionParams constructor.
     *
     * Initializes the connection parameters based on the provided driver and configuration array.
     * It validates the SQLite database path and ensures the file exists.
     *
     * @param  string  $driver  The name of the database driver (e.g., 'sqlite')
     * @param  array  $dbConfig  An associative array containing the database connection settings:
     *                           'sqlite_path' => The path to the SQLite database file
     *
     * @throws PDOException If the database path is missing or the SQLite database file does not exist
     */
    public function __construct(string $driver, array $dbConfig)
    {
        $this->database = $this->getDataBasePath($dbConfig['sqlite_path']) ?? '';

        if (empty($this->database)) {
            throw new PDOException('SQLite database path is required.');
        }

        if (! file_exists($this->database)) {
            throw new PDOException('SQLite database file not found at: '.$this->database);
        }
    }

    /**
     * Retrieves the connection string for SQLite.
     *
     * @return string The SQLite connection string, including the database file path
     */
    public function getConnectionString(): string
    {
        return "sqlite:$this->database";
    }

    /**
     * SQLite does not require a username for connection, so this method returns an empty string.
     *
     * @return string An empty string, as SQLite does not use a user for authentication
     */
    public function getUser(): string
    {
        return '';
    }

    /**
     * SQLite does not require a password for connection, so this method returns an empty string.
     *
     * @return string An empty string, as SQLite does not use a password for authentication
     */
    public function getPassword(): string
    {
        return '';
    }

    /**
     * Converts the provided database path to the correct format with forward slashes.
     *
     * @param  string  $path  The relative path to the SQLite database file
     * @return string The formatted path with forward slashes
     */
    private function getDataBasePath(string $path): string
    {
        return str_replace(DIRECTORY_SEPARATOR, '/', APP_ROOT.'/'.$path);
    }
}
