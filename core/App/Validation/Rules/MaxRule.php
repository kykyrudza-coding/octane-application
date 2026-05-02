<?php

namespace Kernel\Application\Validation\Rules;

/**
 * Class MaxRule
 *
 * Validates if the value does not exceed a specified maximum length.
 */
class MaxRule implements ValidationRule
{
    /**
     * Validate if the value does not exceed the specified maximum length.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  mixed  $value  The value of the field.
     * @param  array  $parameters  The maximum length as the first parameter.
     * @return bool True if the value's length is less than or equal to the maximum, false otherwise.
     */
    public function validate(string $field, mixed $value, array $parameters = []): bool
    {
        $max = $parameters[0] ?? PHP_INT_MAX;

        return is_string($value) && strlen($value) <= $max;
    }

    /**
     * Get the error message if the value exceeds the maximum length.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  array  $parameters  The maximum length as the first parameter.
     * @return string The error message for exceeding the maximum length.
     */
    public function getMessage(string $field, array $parameters = []): string
    {
        return "The field '{$field}' must not exceed {$parameters[0]} characters.";
    }
}
