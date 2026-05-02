<?php

namespace Kernel\Application\Validation\Validator;

use Kernel\Application\Validation\RuleFactory;

/**
 * Class Validator
 *
 * Validates data against a set of rules and collects error messages for failed validations.
 */
class Validator
{
    /**
     * @var array Validation errors collected during validation.
     */
    protected array $errors = [];

    /**
     * @var array Validation rules to apply.
     */
    protected array $rules = [];

    /**
     * @var array Data to validate.
     */
    protected array $data = [];

    /**
     * Set validation rules.
     *
     * @param  array  $rules  Associative array of field names and their rules.
     */
    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }

    /**
     * Set the data to validate.
     *
     * @param  array  $data  Associative array of field names and their values.
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Validate the data against the rules.
     *
     * Populates $errors with validation messages if rules are violated.
     */
    public function validate(): void
    {
        foreach ($this->rules as $field => $fieldRules) {
            $value = $this->data[$field] ?? null;

            foreach ($fieldRules as $rule) {
                [$ruleName, $parameters] = $this->parseRule($rule);
                $ruleInstance = RuleFactory::make($ruleName);

                if (! $ruleInstance->validate($field, $value, $parameters)) {
                    $this->errors[$field][] = $ruleInstance->getMessage($field, $parameters);
                }
            }
        }
    }

    /**
     * Parse a validation rule string.
     *
     * @param  string  $rule  Validation rule (e.g., "max:255").
     * @return array Array with rule name and parameters.
     */
    private function parseRule(string $rule): array
    {
        $parts = explode(':', $rule);
        $ruleName = $parts[0];
        $parameters = isset($parts[1]) ? explode(',', $parts[1]) : [];

        return [$ruleName, $parameters];
    }

    /**
     * Check if validation failed.
     *
     * @return bool True if there are errors, false otherwise.
     */
    public function hasErrors(): bool
    {
        return ! empty($this->errors);
    }

    /**
     * Get validation errors.
     *
     * @return array Array of errors grouped by field name.
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
