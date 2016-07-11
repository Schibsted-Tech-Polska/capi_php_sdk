<?php

namespace Snt\Capi\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Snt\Capi\Http\Exception\CouldNotMakeHttpGetRequest;

class HttpClient implements HttpClientInterface
{
    const API_KEY_HEADER = 'X-Snd-ApiKey';
    
    const API_SIGNATURE_HEADER = 'X-Snd-ApiSignature';

    /**
     * @var HttpClientConfigurationInterface
     */
    protected $httpClientConfiguration;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @param HttpClientConfigurationInterface $httpClientConfiguration
     * @param ClientInterface $client
     */
    public function __construct(
        HttpClientConfigurationInterface $httpClientConfiguration,
        ClientInterface $client
    ) {
        $this->httpClientConfiguration = $httpClientConfiguration;
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function get($path)
    {
        try {
            $response = $this->client->request(
                self::GET_REQUEST,
                $this->buildUri($path),
                $this->buildOptions()
            );
        } catch (GuzzleException $exception) {
            throw new CouldNotMakeHttpGetRequest(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return $response->getBody()->getContents();
    }

    private function buildUri($path)
    {
        return sprintf('%s/%s', $this->httpClientConfiguration->getEndpoint(), $path);
    }

    private function buildOptions()
    {
        return [
            'headers' => [
                self::API_KEY_HEADER => $this->httpClientConfiguration->getApiKey(),
                self::API_SIGNATURE_HEADER => $this->httpClientConfiguration->getApiSecret(),
            ],
        ];
    }
}
