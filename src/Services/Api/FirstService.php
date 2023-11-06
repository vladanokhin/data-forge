<?php

namespace Src\Services\Api;


class FirstService extends MetricsServiceApi
{

    protected string $serviceUrl = 'https://submitter.tech/test-task/endpoint1.json';

    protected function getKeys(): array
    {
       return [
           'name'           => 'name',
           'clicks'         => 'clicks',
           'leads'          => 'leads',
           'roi'            => 'roi',
           'unique_clicks'  => 'unique_clicks',
       ];
    }

    protected function getRulesValidation(): array
    {
        return [
            'status_code' => 200,
        ];
    }

    public function getRelationship(): array
    {
        return [
            'id'         => 'name',
            'foreignKey' => [SecondService::class, 'ad_id']
        ];
    }
}
