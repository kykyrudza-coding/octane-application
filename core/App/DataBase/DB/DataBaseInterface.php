<?php

namespace Kernel\Application\DataBase\DB;

/**
 * Interface DataBaseInterface
 *
 * Provides a contract for basic database operations.
 * Includes methods for creating, updating, deleting, and retrieving data.
 */
interface DataBaseInterface
{
    /**
     * Creates a new record in the database.
     *
     * @param  array  $data  An associative array of data to be inserted.
     */
    public function create(array $data): void;

    /**
     * Updates an existing record in the database.
     *
     * @param  int  $id  The ID of the record to update.
     * @param  array  $data  An associative array of updated data.
     */
    public function update(int $id, array $data): void;

    /**
     * Deletes a record from the database.
     *
     * @param  int  $id  The ID of the record to delete.
     */
    public function delete(int $id): void;

    /**
     * Finds a record in the database by its ID.
     *
     * @param  int  $id  The ID of the record to find.
     * @return mixed The found record, or null if no record is found.
     */
    public function find(int $id);

    /**
     * Retrieves all records from the database.
     *
     * @return array An array of all records.
     */
    public function all(): array;

    /**
     * Retrieves the first record from the database.
     *
     * @return array|null The first record as an associative array, or null if no records exist.
     */
    public function first(): ?array;

    /**
     * Retrieves records that match the specified conditions.
     *
     * @param  array  $conditions  An associative array of conditions (e.g., ['column' => 'value']).
     * @return array An array of records matching the conditions.
     */
    public function where(array $conditions): array;
}
