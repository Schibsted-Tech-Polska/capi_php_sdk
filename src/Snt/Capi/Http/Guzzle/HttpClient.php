<?php

namespace Snt\Capi\Http\Guzzle;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Snt\Capi\Http\AbstractHttpClient;
use Snt\Capi\Http\Exception\CouldNotMakeHttpGetRequest;
use Snt\Capi\Http\HttpClientConfiguration;

class HttpClient extends AbstractHttpClient
{
    const API_KEY_HEADER = 'X-Snd-ApiKey';
    
    const API_SIGNATURE_HEADER = 'X-Snd-ApiSignature';

    /**
     * @var ClientInterface
     */
    protected $client;

    public function __construct(
        HttpClientConfiguration $httpClientConfiguration,
        ClientInterface $client
    ) {
        $this->client = $client;
        parent::__construct($httpClientConfiguration);
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
