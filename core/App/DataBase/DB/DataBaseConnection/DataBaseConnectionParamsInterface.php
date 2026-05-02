<?php

namespace Kernel\Application\DataBase\DB\DataBaseConnection;

/**
 * Interface DataBaseConnectionParamsInterface
 *
 * This interface defines the methods required for getting the connection parameters
 * needed to establish a connection with a specific type of database. Implementations
 * of this interface provide the necessary logic for returning the connection string,
 * user credentials, and password for different database types (e.g., MySQL, PostgresSQL, SQLite).
 */
interface DataBaseConnectionParamsInterface
{
    /**
     * Get the connection string for the database.
     *
     * @return string The connection string used to connect to the database
     */
    public function getConnectionString(): string;

    /**
     * Get the username for the database connection.
     *
     * @return string The username for the database connection
     */
    public function getUser(): string;

    /**
     * Get the password for the database connection.
     *
     * @return string The password for the database connection
     */
    public function getPassword(): string;
}
