<?php

namespace Src\Contracts\Services;

use Src\Contracts\Repositories\IMetricRepository;

interface IMetricsData
{

    /**
     * Save extracted metric data to repository
     * @param IMetricRepository $repository
     * @return void
     */
    public function saveTo(IMetricRepository $repository): void;

}
