<?php

namespace Src\Services\Api;

class SecondService extends MetricsServiceApi
{

    protected string $serviceUrl = 'https://submitter.tech/test-task/endpoint2.json';

    protected string|null $responseKeyPath = 'data.list';

    protected function getKeys(): array
    {
       return [
           'ad_id'       => 'dimensions.ad_id',
           'impressions' => 'metrics.impressions',
           'conversion'  => 'metrics.conversion',
       ];
    }

    protected function getRulesValidation(): array
    {
        return [
            'status_code'   => 200,
            'required_keys' => ['data.list'],
            'has_value'     => ['message', 'OK']
        ];
    }
}
