<?php

namespace Kernel\Application\Validation\Rules;

/**
 * Class NumericRule
 *
 * Validates if the value is a numeric value.
 */
class NumericRule implements ValidationRule
{
    /**
     * Validate if the value is numeric.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  mixed  $value  The value of the field.
     * @param  array  $parameters  Optional parameters (unused for this rule).
     * @return bool True if the value is numeric, false otherwise.
     */
    public function validate(string $field, mixed $value, array $parameters = []): bool
    {
        return is_numeric($value);
    }

    /**
     * Get the error message if the value is not numeric.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  array  $parameters  Optional parameters (unused for this rule).
     * @return string The error message for not being numeric.
     */
    public function getMessage(string $field, array $parameters = []): string
    {
        return "The field '{$field}' must be numeric.";
    }
}
