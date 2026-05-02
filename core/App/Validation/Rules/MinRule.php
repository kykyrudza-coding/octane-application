<?php

namespace Kernel\Application\Validation\Rules;

/**
 * Class MinRule
 *
 * Validates if the value is at least a specified minimum length.
 */
class MinRule implements ValidationRule
{
    /**
     * Validate if the value meets the minimum length requirement.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  mixed  $value  The value of the field.
     * @param  array  $parameters  The minimum length as the first parameter.
     * @return bool True if the value's length is greater than or equal to the minimum, false otherwise.
     */
    public function validate(string $field, mixed $value, array $parameters = []): bool
    {
        $min = $parameters[0] ?? 0;

        return is_string($value) && strlen($value) >= $min;
    }

    /**
     * Get the error message if the value does not meet the minimum length.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  array  $parameters  The minimum length as the first parameter.
     * @return string The error message for not meeting the minimum length.
     */
    public function getMessage(string $field, array $parameters = []): string
    {
        return "The field '{$field}' must be at least {$parameters[0]} characters long.";
    }
}
