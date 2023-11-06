<?php

namespace Src\Contracts\Services;

use Src\Contracts\Repositories\IMetricRepository;
use Src\Enums\SortDirection;

interface IMetricsData
{

    /**
     * Save extracted metric data to repository
     * @param IMetricRepository $repository
     * @return void
     */
    public function saveTo(IMetricRepository $repository): void;

    /**
     * @param string $key
     * @param int $direction
     * @return void
     */
    public function sortBy(string $key, int $direction): void;

}
