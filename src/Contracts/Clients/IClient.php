<?php

namespace Src\Contracts\Clients;

use Generator;

interface IClient
{
    /**
     * Extract all data from service
     * @param array $validationRules
     * @return Generator
     */
    public function getAll(array $validationRules): Generator;
}
