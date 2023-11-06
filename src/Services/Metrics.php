<?php

namespace Src\Services;

use Src\Contracts\Services\IMetricsService;

/**
 * Loading all metrics from external services
 */
class Metrics
{

    /**
     *
     * @param class-string<IMetricsService>[] $services
     * @return void
     */
    static public function loadFrom(array $services): void
    {
        $data = [];
        $metrics = new self();

        /**
         * @var $service IMetricsService
         */
        foreach ($services as $service) {
            $service = new $service;
            $data += $service->load();
        }

        $metrics->save($data);
    }

    public function save(array $data)
    {

    }
}
