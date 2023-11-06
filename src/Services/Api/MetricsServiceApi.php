<?php

namespace Src\Services\Api;

use Generator;
use Src\Contracts\Clients\IClient;
use Src\Contracts\Services\IMetricsService;
use Src\Exceptions\ValidationException;
use Src\Services\Clients\ApiClient;

/**
 * Abstract class for api service
 */
abstract class MetricsServiceApi implements IMetricsService
{

    /**
     * Client for receiving data from the service
     */
    private IClient $client;

    /**
     * Keys from which values will be extracted
     */
    private array $keys;

    /**
     * Url to service
     */
    protected string $serviceUrl;

    /**
     * Path to data in the response array
     */
    protected string|null $responseKeyPath = null;

    public function __construct()
    {
        $this->client = new ApiClient($this->serviceUrl, $this->responseKeyPath);
        $this->keys = $this->getKeys();
    }

    /**
     * Get the keys from which the value will be extracted
     * @return array
     */
    abstract protected function getKeys(): array;

    /**
     * Get validation rules for the api response
     * @return array
     */
    abstract protected function getRulesValidation(): array;

    /**
     * Load the data from external service
     * @throws ValidationException
     */
    public function load(): array
    {
        return $this->filterByKeys(
            $this->client->getAll($this->getRulesValidation())
        );
    }

    /**
     * Filter the received data,
     * only values by keys are selected
     * @param Generator $data
     * @return array
     */
    protected function filterByKeys(Generator $data): array
    {
        $result = [];

        foreach ($data as $index => $item) {
            foreach ($this->keys as $keyName => $key) {
                $result[$index][$keyName] = dot($item)->get($key);
            }
        }

        return $result;
    }
}
