<?php

namespace Kernel\Application\DataBase\DB;

use PDO;
use PDOException;

/**
 * Class DataBase
 *
 * This class provides basic database operations for interacting with a specific
 * database table. It supports CRUD (Create, Read, Update, Delete) operations.
 * The class leverages PDO for database interaction and prepares SQL queries
 * for insertion, updating, deletion, and selection of data from the table.
 */
class DataBase
{
    /**
     * @var PDO The PDO instance used for database connection and execution
     */
    private PDO $pdo;

    /**
     * @var string The name of the table to interact with
     */
    private string $table;

    /**
     * DataBase constructor.
     *
     * Initializes the database object with the given PDO instance and table name.
     *
     * @param  PDO  $pdo  The PDO instance used to interact with the database
     * @param  string  $table  The name of the table to perform operations on
     */
    public function __construct(PDO $pdo, string $table)
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    /**
     * Inserts data into the table.
     *
     * @param  array  $data  The associative array of column names and their corresponding values
     *
     * @throws PDOException If the insert operation fails
     */
    public function create(array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':'.implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if (! $stmt->execute()) {
            throw new PDOException('Failed to insert data');
        }

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Updates data in the table based on the given ID.
     *
     * @param  int  $id  The ID of the record to update
     * @param  array  $data  The associative array of column names and their new values
     *
     * @throws PDOException If the update operation fails
     */
    public function update(int $id, array $data): void
    {
        $setStatements = [];
        foreach ($data as $column => $value) {
            $setStatements[] = "$column = :$column";
        }
        $setString = implode(', ', $setStatements);

        $sql = "UPDATE {$this->table} SET $setString WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if (! $stmt->execute()) {
            throw new PDOException('Failed to update data');
        }
    }

    /**
     * Deletes a record from the table based on the given ID.
     *
     * @param  int  $id  The ID of the record to delete
     *
     * @throws PDOException If the delete operation fails
     */
    public function delete(int $id): void
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);

        if (! $stmt->execute()) {
            throw new PDOException('Failed to delete data');
        }
    }

    /**
     * Finds a record in the database by its ID.
     *
     * @param  int  $id  The ID of the record to find.
     * @return mixed The found record, or null if no record is found.
     */
    public function find(int $id): mixed
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves all records from the database.
     *
     * @return array An array of all records.
     */
    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves the first record from the database.
     *
     * @return array|null The first record as an associative array, or null if no records exist.
     */
    public function first(): ?array
    {
        $sql = "SELECT * FROM {$this->table} LIMIT 1";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Retrieves records that match the specified conditions.
     *
     * @param  array  $conditions  An associative array of conditions (e.g., ['column' => 'value']).
     * @return array An array of records matching the conditions.
     */
    public function where(array $conditions): array
    {
        $whereStatements = [];
        foreach ($conditions as $column => $value) {
            $whereStatements[] = "$column = :$column";
        }
        $whereString = implode(' AND ', $whereStatements);

        $sql = "SELECT * FROM {$this->table} WHERE $whereString";
        $stmt = $this->pdo->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
