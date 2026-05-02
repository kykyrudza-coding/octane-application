<?php

namespace Kernel\Application\Validation\Rules;

/**
 * Class PasswordConfirmationRule
 *
 * Validates if the password and confirmation match.
 */
class PasswordConfirmationRule implements ValidationRule
{
    /**
     * Validate if the value matches the confirmation password.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  mixed  $value  The value of the field.
     * @param  array  $parameters  The confirmation value as the first parameter.
     * @return bool True if the value matches the confirmation, false otherwise.
     */
    public function validate(string $field, mixed $value, array $parameters = []): bool
    {
        $confirmationValue = $parameters[0] ?? null;

        return $value === $confirmationValue;
    }

    /**
     * Get the error message if the value does not match the confirmation.
     *
     * @param  string  $field  The name of the field being validated.
     * @param  array  $parameters  The confirmation value as the first parameter.
     * @return string The error message for not matching the confirmation.
     */
    public function getMessage(string $field, array $parameters = []): string
    {
        return "The {$field} does not match the confirmation.";
    }
}
