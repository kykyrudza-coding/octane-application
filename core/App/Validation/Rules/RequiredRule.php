<?php

namespace Kernel\Application\Validation\Rules;

/**
 * Class RequiredRule
 *
 * Validates if the field is not empty.
 */
class RequiredRule implements ValidationRule
{
    /**
     * Validate if the value is not empty.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  mixed  $value  The value of the field.
     * @param  array  $parameters  Optional parameters (unused for this rule).
     * @return bool True if the value is not empty, false otherwise.
     */
    public function validate(string $field, mixed $value, array $parameters = []): bool
    {
        return ! empty($value);
    }

    /**
     * Get the error message if the value is empty.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  array  $parameters  Optional parameters (unused for this rule).
     * @return string The error message for being empty.
     */
    public function getMessage(string $field, array $parameters = []): string
    {
        return "The field '{$field}' is required.";
    }
}
