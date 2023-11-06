<?php

namespace Src\Services;

use Src\Contracts\Services\IMetricsData;

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
            $foreignData = $this->getDataFromForeignClass($foreignClass, $item[$id], $foreignKey);
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
     * Get the extracted data
     * @return array
     */
    public function get(): array
    {
        return $this->data;
    }
}
