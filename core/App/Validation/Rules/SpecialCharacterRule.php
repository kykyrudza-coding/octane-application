<?php

namespace Kernel\Application\Validation\Rules;

/**
 * Class SpecialCharacterRule
 *
 * Validates if the value contains at least one special character.
 */
class SpecialCharacterRule implements ValidationRule
{
    /**
     * Validate if the value contains at least one special character.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  mixed  $value  The value of the field.
     * @param  array  $parameters  Optional parameters (unused for this rule).
     * @return bool True if the value contains a special character, false otherwise.
     */
    public function validate(string $field, mixed $value, array $parameters = []): bool
    {
        return is_string($value) && preg_match('/[\W_]/', $value);
    }

    /**
     * Get the error message if the value does not contain a special character.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  array  $parameters  Optional parameters (unused for this rule).
     * @return string The error message for not containing a special character.
     */
    public function getMessage(string $field, array $parameters = []): string
    {
        return "The {$field} must contain at least one special character (e.g., @, #, $, etc.).";
    }
}
