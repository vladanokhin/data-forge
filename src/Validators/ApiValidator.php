<?php

namespace Src\Validators;

use Adbar\Dot as ArrayDot;
use Psr\Http\Message\ResponseInterface;

/**
 * Api validations
 */
class ApiValidator extends Validator
{

    protected array $methods = [
        'required_keys',
        'has_value',
        'status_code',
    ];

    private ResponseInterface $response;

    private ArrayDot $data;

    public function __construct(mixed $data, array $rules)
    {
        parent::__construct($data, $rules);
        $this->response = $data;
        $this->rules = $rules;
        $this->convertToArrayDot();
    }

    /**
     * Convert the response body to ArrayDot
     * @return void
     */
    private function convertToArrayDot()
    {
        $this->data = new ArrayDot(
            json_decode($this->response->getBody()->getContents())
        );
    }

    /**
     * Check if the key data is available
     * @param array|int|string $keys
     * @return bool
     */
    private function required_keys(array|int|string $keys): bool
    {
        return $this->data->has($keys);
    }

    /**
     * Check if there is a value for the specified key
     * @param string $key
     * @param string $value
     * @return bool
     */
    private function has_value(string $key, string $value): bool
    {
        return $this->data->get($key) === $value;
    }

    /**
     * Check the status code of response
     * @param int $status
     * @return bool
     */
    private function status_code(int $status): bool
    {
        return $this->response->getStatusCode() === $status;
    }
}
