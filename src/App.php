<?php

namespace Src;


use Src\Enums\SortDirection;
use Src\Repositories\DbMetricRepository;
use Src\Services\Api\FirstService;
use Src\Services\Api\SecondService;
use Src\Services\Metrics;

/**
 * The class of application
 */
class App
{
    /**
     * Start application
     * @return void
     */
    public function run()
    {
        $repository = new DbMetricRepository();
        $metricsData = Metrics::loadFrom([
            FirstService::class,
            SecondService::class,
        ]);
        $metricsData->sortBy('impressions', SortDirection::ASC);
        $metricsData->saveTo($repository);
    }
}
