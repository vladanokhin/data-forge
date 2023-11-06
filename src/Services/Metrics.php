<?php

namespace Src\Services;

use Src\Contracts\Services\IMetricsData;
use Src\Contracts\Services\IMetricsService;

/**
 * Loading all metrics from external services
 */
class Metrics
{

    /**
     * Load metrics from services
     * @param class-string<IMetricsService>[] $services
     * @return IMetricsData
     */
    static public function loadFrom(array $services): IMetricsData
    {
        $data = [];

        /**
         * @var $service IMetricsService
         */
        foreach ($services as $service) {
            $service = new $service;
            $data[$service::class]['_object'] = $service;
            $data[$service::class]['data'] = $service->load();
        }

        return new MetricsData($data);
    }
}
