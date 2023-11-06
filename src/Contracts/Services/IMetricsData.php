<?php

namespace Src\Contracts\Services;

interface IMetricsData
{

    /**
     * Get the extracted data
     * @return array
     */
    public function get(): array;

}
