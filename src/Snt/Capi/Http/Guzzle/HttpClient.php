<?php

namespace Snt\Capi\Http\Guzzle;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Snt\Capi\Http\AbstractHttpClient;
use Snt\Capi\Http\Exception\HttpException;
use Snt\Capi\Http\Exception\HttpExceptionReason;
use Snt\Capi\Http\HttpClientConfiguration;
use Snt\Capi\Http\HttpRequestParameters;

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
    public function get(HttpRequestParameters $httpRequestParameters)
    {
        try {
            $response = $this->client->request(
                self::GET_REQUEST,
                $this->buildUri($httpRequestParameters),
                $this->buildOptions()
            );
        } catch (GuzzleException $exception) {
            throw new HttpException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception,
                $this->createHttpExceptionReason($exception)
            );
        }

        return $response->getBody()->getContents();
    }

    private function buildUri(HttpRequestParameters $httpRequestParameters)
    {
        $endpointWithPath = sprintf(
            '%s/%s',
            $this->httpClientConfiguration->getEndpoint(),
            $httpRequestParameters->getPath()
        );

        return sprintf('%s?%s', $endpointWithPath, $httpRequestParameters->getQuery());
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

    private function createHttpExceptionReason(GuzzleException $exception)
    {
        if (!$exception instanceof ClientException) {
            return null;
        }

        $response = $exception->getResponse();

        return $response instanceof ResponseInterface && $response->getStatusCode() === self::NOT_FOUND_STATUS_CODE
            ? HttpExceptionReason::createForNotFoundError()
            : null;
    }
}
