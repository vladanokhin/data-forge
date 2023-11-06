<?php

namespace Src\Contracts\Repositories;

use Generator;

interface IMetricRepository
{

    /**
     * Insert metrics data
     * @param array $metrics
     */
    public function insert(array $metrics): void;

    /**
     * Check if the metric exists
     * @param int $id
     * @return bool
     */
    public function exists(int $id): bool;

    /**
     * Update metrics data
     * @param array $metrics
     * @param array $conditions
     * @return void
     */
    public function update(array $metrics, array $conditions): void;


    /**
     * Get all the data
     * @return Generator
     */
    public function getAll(): Generator;
}
