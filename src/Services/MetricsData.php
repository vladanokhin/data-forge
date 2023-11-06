<?php

namespace Src\Services;

use Src\Contracts\Repositories\IMetricRepository;
use Src\Contracts\Services\IMetricsData;
use Src\Enums\SortDirection;

/**
 * Processing metrics data
 */
class MetricsData implements IMetricsData
{

    /**
     * Prepared metrics data
     */
    private array $data = [];

    /**
     * Data from various services for processing
     */
    private array $servicesData;

    /**
     * Services from which the data was extracted
     */
    private array $extractedServices = [];

    public function __construct(array $data)
    {
        $this->servicesData = $data;
        $this->combine();
    }

    /**
     * Combine all data from different services
     * @return void
     */
    private function combine(): void
    {
        foreach($this->servicesData as $serviceName => $service) {

            if($this->isServiceAlreadyExtracted($serviceName))
                continue;

            if(empty($service['_object']->getRelationship())) {
                $this->data += $service['data'];  // If there are no relationships, just append the data
            } else {
                $this->getDataFromRelations(
                    $service['_object']->getRelationship(),
                    $service['data']
                );
            }
        }
    }

    /**
     * Getting data from relationships
     * @param array $relationships
     * @param array $data
     * @return void
     */
    private function getDataFromRelations(array $relationships, array $data)
    {
        $id = $relationships['id'];
        [$foreignClass, $foreignKey] = $relationships['foreignKey'];
        $foreignService = $this->servicesData[$foreignClass];

        foreach ($data as $item) {
            //Skip metrics without the correct id
            if((int) $item[$id] === 0)
                continue;

            $foreignData = $this->getDataFromForeignClass($foreignClass, $item[$id], $foreignKey);

            if(empty($foreignData))
                continue;

            $this->data[] = $item + $foreignData;
        }

        if(!empty($foreignService['_object']->getRelationship())) {
            $this->getDataFromRelations(
                $foreignService['_object']->getRelationship(),
                $foreignService['data']
            );
        }

        $this->setsServiceAlreadyExtracted($foreignClass);
    }

    /**
     * Get the data of foreign class by key and value
     * @param string $foreignClass
     * @param string $parentId
     * @param string $key
     * @return array
     */
    private function getDataFromForeignClass(string $foreignClass, string $parentId, string $key): array
    {
        foreach ($this->servicesData[$foreignClass]['data'] as $servicesData) {
            if($servicesData[$key] === $parentId)
                return $servicesData;
        }

        return [];
    }

    /**
     * If the service has already been extracted
     * @param string $serviceClass
     * @return bool
     */
    private function isServiceAlreadyExtracted(string $serviceClass): bool
    {
        return in_array($serviceClass, $this->extractedServices);
    }

    /**
     * Determine that the service
     * has already been extracted
     * @param string $serviceClass
     * @return void
     */
    private function setsServiceAlreadyExtracted(string $serviceClass): void
    {
        $this->extractedServices[] = $serviceClass;
    }

    /**
     * Save extracted metric data to repository
     * @param IMetricRepository $repository
     * @return void
     */
    public function saveTo(IMetricRepository $repository): void
    {
        foreach ($this->data as $metrics) {
            $metrics = $this->prepareToSaving($metrics);

            if($repository->exists($metrics['ad_id']))
                $repository->update($metrics, ['ad_id' => $metrics['ad_id']]);
            else
                $repository->insert($metrics);
        }
    }

    /**
     * Prepare data before saving using a repository
     * @param array $metrics
     * @return array
     */
    private function prepareToSaving(array $metrics)
    {
        unset($metrics['name']);

        // Convert to a percentage
        $roiPercent = round((float)$metrics['roi']);
        $metrics['roi'] = $roiPercent;

        return $metrics;
    }

    /**
     * @param string $key
     * @param int $direction
     * @return void
     */
    public function sortBy(string $key, int $direction): void
    {
       $this->data = ArraySorter::sortByKey($key, $this->data, $direction);
    }
}
