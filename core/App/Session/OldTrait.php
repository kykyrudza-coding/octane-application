<?php

namespace Kernel\Application\Session;

/**
 * Trait OldTrait
 *
 * This trait provides functionality for handling old input data.
 * It's typically used to preserve data between requests, such as form data
 * that should be returned to the user after a form submission.
 */
trait OldTrait
{
    /**
     * @var array The array to store old input data.
     */
    protected array $old = [];

    /**
     * Sets old input data.
     *
     * This method stores a specific piece of input data that should be
     * preserved across requests, such as form data after a failed validation.
     *
     * @param  string  $key  The key to identify the input data.
     * @param  mixed  $value  The value of the input data to be stored.
     */
    public function setOld(string $key, mixed $value): void
    {
        $this->old[$key] = $value;
        $this->saveDataToFile();  // Optionally save the old data to persistent storage.
    }

    /**
     * Retrieves old input data.
     *
     * This method retrieves and removes the stored old input data by its key.
     * It is used to display previously entered data, such as after form submission.
     *
     * @param  string  $key  The key of the stored input data.
     * @return mixed The stored input data value, or null if the key does not exist.
     */
    public function getOld(string $key): mixed
    {
        $value = $this->old[$key] ?? null;
        unset($this->old[$key]);  // Removes the old data after it has been retrieved.

        return $value;
    }

    /**
     * Clears all old input data.
     *
     * This method clears the entire array of old input data, ensuring that no
     * data is retained across requests once it has been retrieved.
     */
    private function clearOldData(): void
    {
        $this->old = [];
    }
}
