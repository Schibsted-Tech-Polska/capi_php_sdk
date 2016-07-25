<?php

namespace Snt\Capi\Http;

use Http\Client\Exception;
use Http\Client\Exception\HttpException;
use Http\Client\HttpClient as HttpClientInterface;
use Http\Message\RequestFactory as RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Snt\Capi\Http\Exception\ApiHttpClientException;
use Snt\Capi\Http\Exception\ApiHttpClientNotFoundException;

class ApiHttpClient implements ApiHttpClientInterface
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var ApiHttpClientConfiguration
     */
    protected $apiHttpClientConfiguration;

    /**
     * @var RequestFactoryInterface
     */
    protected $requestFactory;

    /**
     * @param HttpClientInterface $httpClient
     * @param ApiHttpClientConfiguration $apiHttpClientConfiguration
     * @param RequestFactoryInterface $requestFactory
     */
    public function __construct(
        HttpClientInterface $httpClient,
        ApiHttpClientConfiguration $apiHttpClientConfiguration,
        RequestFactoryInterface $requestFactory
    ) {
        $this->httpClient = $httpClient;
        $this->apiHttpClientConfiguration = $apiHttpClientConfiguration;
        $this->requestFactory = $requestFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function get(ApiHttpPathAndQuery $apiHttpPathAndQuery)
    {
        try {
            $request = $this->requestFactory->createRequest(
                self::GET_REQUEST,
                $this->apiHttpClientConfiguration->buildUri($apiHttpPathAndQuery),
                $this->apiHttpClientConfiguration->buildHeaders()
            );

            $response = $this->httpClient->sendRequest($request);
        } catch (Exception $exception) {
            if ($this->isNotFoundError($exception)) {
                throw new ApiHttpClientNotFoundException(
                    $this->apiHttpClientConfiguration->buildUri($apiHttpPathAndQuery)
                );
            }
            throw new ApiHttpClientException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return $response->getBody()->getContents();
    }

    private function isNotFoundError(Exception $exception)
    {
        return $exception instanceof HttpException
            && $exception->getResponse()->getStatusCode() == self::NOT_FOUND_STATUS_CODE;
    }
}
