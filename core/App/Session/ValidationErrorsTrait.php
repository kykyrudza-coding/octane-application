<?php

namespace Kernel\Application\Session;

/**
 * Trait ValidationErrorsTrait
 *
 * This trait provides methods to manage validation error messages in the session.
 * It allows for storing, retrieving, and checking validation errors, and also
 * clearing the error messages when needed.
 */
trait ValidationErrorsTrait
{
    /**
     * @var array The array of validation error messages.
     */
    protected array $validationErrors = [];

    /**
     * Retrieves all validation errors stored in the session.
     *
     * @return array An associative array of validation errors.
     */
    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    /**
     * Sets the validation errors in the session.
     *
     * @param  array  $validationErrors  An associative array of validation errors.
     */
    public function setValidationErrors(array $validationErrors): void
    {
        $this->validationErrors = $validationErrors;
        $this->saveDataToFile();
    }

    /**
     * Checks if a specific validation error exists for a given key.
     *
     * @param  string  $key  The key to check for a validation error.
     * @return bool True if the validation error exists for the given key, false otherwise.
     */
    public function hasValidationErrors(string $key): bool
    {
        return isset($this->validationErrors[$key]);
    }

    /**
     * Alias for hasValidationErrors method.
     *
     * @param  string  $key  The key to check for a validation error.
     * @return bool True if the validation error exists for the given key, false otherwise.
     */
    public function hasValidationError(string $key): bool
    {
        return isset($this->validationErrors[$key]);
    }

    /**
     * Retrieves a specific validation error by its key.
     *
     * @param  string  $key  The key of the validation error to retrieve.
     * @return mixed The validation error message or null if not found.
     */
    public function getValidationError(string $key): mixed
    {
        return $this->validationErrors[$key] ?? null;
    }

    /**
     * Clears all validation errors from the session.
     */
    private function clearValidationErrors(): void
    {
        $this->validationErrors = [];
    }
}
