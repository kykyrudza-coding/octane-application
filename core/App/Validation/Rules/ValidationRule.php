<?php

namespace Kernel\Application\Validation\Rules;

/**
 * Interface ValidationRule
 *
 * This interface defines the structure for validation rules. Each validation rule class should implement this interface.
 * The `validate` method checks if a field value satisfies the validation rule, and the `getMessage` method returns
 * an error message if validation fails.
 */
interface ValidationRule
{
    /**
     * Validate the value of a field based on a specific rule.
     *
     * @param  string  $field  The name of the field to be validated.
     * @param  mixed  $value  The value of the field.
     * @param  array  $parameters  Optional parameters for the validation rule.
     * @return bool True if the validation passes, false otherwise.
     */
    public function validate(string $field, mixed $value, array $parameters = []): bool;

    /**
     * Get the error message if the validation fails.
     *
     * @param  string  $field  The name of the field that failed validation.
     * @param  array  $parameters  Optional parameters for the validation rule.
     * @return string The error message.
     */
    public function getMessage(string $field, array $parameters = []): string;
}
