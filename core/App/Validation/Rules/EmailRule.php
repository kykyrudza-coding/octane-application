<?php

namespace Kernel\Application\Validation\Rules;

/**
 * Class EmailRule
 *
 * Validates if the value is a valid email address using PHP's built-in filter.
 */
class EmailRule implements ValidationRule
{
    /**
     * Validate if the value is a valid email.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  mixed  $value  The value of the field.
     * @param  array  $parameters  Optional parameters (unused for this rule).
     * @return bool True if the value is a valid email address, false otherwise.
     */
    public function validate(string $field, mixed $value, array $parameters = []): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Get the error message if the value is not a valid email.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  array  $parameters  Optional parameters (unused for this rule).
     * @return string The error message for invalid email.
     */
    public function getMessage(string $field, array $parameters = []): string
    {
        return "The field '{$field}' must be a valid email address.";
    }
}
