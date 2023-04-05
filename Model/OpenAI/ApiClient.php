<?php

namespace Magecomp\Chatgptaicontent\Model\OpenAI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class ApiClient
{
    private const DEFAULT_REQUEST_TIMEOUT = 60;
    protected Client $client;

    public function __construct(string $baseUrl, string $token)
    {
        $config = [
            'base_uri' => $baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ];

        $this->client = new Client($config);
    }

    public function post(string $url, array $data, ?array $options = []): ResponseInterface
    {
        try {
            return $this->client->post($url, $this->getPreparedOptions($options, $data));
        } catch (BadResponseException $e) {
            return $e->getResponse();
        }
    }

    protected function getPreparedOptions($options, $data): array
    {
        $options[RequestOptions::JSON] = $data;

        if (!isset($options['timeout'])) {
            $options['timeout'] = self::DEFAULT_REQUEST_TIMEOUT;
        }

        if (!isset($options['connect_timeout'])) {
            $options['connect_timeout'] = self::DEFAULT_REQUEST_TIMEOUT;
        }

        return $options;
    }
}
