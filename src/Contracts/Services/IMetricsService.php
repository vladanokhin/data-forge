<?php

namespace Src\Contracts\Services;

interface IMetricsService
{

    /**
     * Load the data from external service
     * @return array
     */
    public function load(): array;

    /**
     * Get a relationship to merge data
     * @return array
     */
    public function getRelationship(): array;
}
