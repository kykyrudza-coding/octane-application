<?php

namespace Kernel\Application\Validation;

use InvalidArgumentException;
use Kernel\Application\Validation\Rules\EmailRule;
use Kernel\Application\Validation\Rules\MaxRule;
use Kernel\Application\Validation\Rules\MinRule;
use Kernel\Application\Validation\Rules\NumberRule;
use Kernel\Application\Validation\Rules\NumericRule;
use Kernel\Application\Validation\Rules\PasswordConfirmationRule;
use Kernel\Application\Validation\Rules\RequiredRule;
use Kernel\Application\Validation\Rules\SpecialCharacterRule;
use Kernel\Application\Validation\Rules\UppercaseRule;
use Kernel\Application\Validation\Rules\ValidationRule;

/**
 * Class RuleFactory
 *
 * This factory class is responsible for creating instances of validation rules.
 * It maps the name of the rule to its corresponding rule class, ensuring the proper
 * validation rule object is created and returned when requested.
 */
class RuleFactory
{
    /**
     * Creates an instance of a validation rule class based on the provided rule name.
     *
     * This static method maps the rule name to the corresponding validation rule class.
     * If an invalid rule name is provided, it throws an InvalidArgumentException.
     *
     * @param  string  $ruleName  The name of the validation rule to create
     * @return ValidationRule The corresponding validation rule class instance
     *
     * @throws InvalidArgumentException If the provided rule name does not exist
     */
    public static function make(string $ruleName): ValidationRule
    {
        return match ($ruleName) {
            'required' => new RequiredRule,
            'email' => new EmailRule,
            'max' => new MaxRule,
            'min' => new MinRule,
            'have_numbers' => new NumberRule,
            'numeric' => new NumericRule,
            'confirm' => new PasswordConfirmationRule,
            'special' => new SpecialCharacterRule,
            'uppercase' => new UppercaseRule,
            default => throw new InvalidArgumentException("Validation rule '{$ruleName}' does not exist."),
        };
    }
}
