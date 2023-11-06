<?php

namespace Src\Contracts\Repositories;

interface IMetricRepository
{

    /**
     * Insert metrics data
     * @param array $metrics
     */
    public function insert(array $metrics);

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
     */
    public function update(array $metrics, array $conditions);
}
