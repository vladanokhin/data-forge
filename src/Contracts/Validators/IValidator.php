<?php

namespace Src\Contracts\Validators;

interface IValidator
{

    public function __construct(mixed $data, array $rules);

    /**
     * Make the validations
     * @param mixed $data
     * @param array $rules
     * @return bool
     */
    static public function make(mixed $data, array $rules): bool;

}
