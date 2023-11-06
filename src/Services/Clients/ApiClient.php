<?php

namespace Src\Services\Clients;

use Generator;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\GuzzleException;
use Src\Contracts\Clients\IClient;
use Src\Exceptions\ValidationException;
use Src\Validators\ApiValidator;

/**
 * Client for receiving data from api
 */
class ApiClient implements IClient
{

    private string $url;

    private string|null $responseKeyPath;

    private Guzzle $client;

    public function __construct(string $url, string|null $responseKeyPath = null)
    {
        $this->url = $url;
        $this->responseKeyPath = $responseKeyPath;
        $this->client = new Guzzle([
            'timeout'  => 5,
        ]);
    }

    /**
     * Extract all data from service
     * @param array $validationRules
     * @return Generator
     * @throws ValidationException
     */
    public function getAll(array $validationRules): Generator
    {
        try {
            $response = $this->client->get($this->url);

            if( !ApiValidator::make($response, $validationRules) )
                yield [];

            $body = json_decode($response->getBody()->getContents(), true);
            $data = dot($body)->get($this->responseKeyPath, []);

            foreach ($data as $item) {
                yield $item;
            }
        }
        catch (GuzzleException) {
            yield [];
        }
    }
}
