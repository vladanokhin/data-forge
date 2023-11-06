<?php

namespace Src\Contracts\Services;

interface IMetricsService
{

    /**
     * Load the data from external service
     * @return array
     */
    public function load(): array;

}
