<?php

namespace Src\Validators;

use Src\Contracts\Validators\IValidator;
use Src\Exceptions\ValidationException;

/**
 * Basic validation class
 */
class Validator implements IValidator
{
    /**
     * The rules for validation are obtained
     */
    protected array $rules = [];

    /**
     * Validation methods available
     */
    protected array $methods = [];

    public function __construct(mixed $data, array $rules)
    {

    }

    /**
     * @param mixed $data
     * @param array $rules
     * @return bool
     * @throws ValidationException
     */
    static public function make(mixed $data, array $rules): bool
    {
        $validator = new self($data, $rules);

        return $validator->checkByRules();
    }

    /**
     * We go through all the rules and check
     * @throws ValidationException
     * @return bool
     */
    protected function checkByRules(): bool
    {
        foreach ($this->rules as $rule => $value) {
            if(!$this->hasRule($rule)) {
                $validationName = get_class($this);
                throw new ValidationException("$validationName has no rule: '$rule'");
            }

            $isValid = is_array($value)
                        ? $this->$rule(...$value)
                        : $this->$rule($value);

            if(!$isValid)
                return false;
        }

        return  true;
    }

    /**
     * Check if the validator has a rule
     * @param string $rule
     * @return bool
     */
    protected function hasRule(string $rule): bool
    {
        return in_array($rule, $this->methods);
    }
}
