<?php

namespace Kernel\Application\Validation\Rules;

/**
 * Class UppercaseRule
 *
 * Validates if the value contains at least one uppercase letter.
 */
class UppercaseRule implements ValidationRule
{
    /**
     * Validate if the value contains at least one uppercase letter.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  mixed  $value  The value of the field.
     * @param  array  $parameters  Optional parameters (unused for this rule).
     * @return bool True if the value contains at least one uppercase letter, false otherwise.
     */
    public function validate(string $field, mixed $value, array $parameters = []): bool
    {
        return is_string($value) && preg_match('/[A-Z]/', $value);
    }

    /**
     * Get the error message if the value does not contain an uppercase letter.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  array  $parameters  Optional parameters (unused for this rule).
     * @return string The error message for not containing an uppercase letter.
     */
    public function getMessage(string $field, array $parameters = []): string
    {
        return "The {$field} must contain at least one uppercase letter.";
    }
}
