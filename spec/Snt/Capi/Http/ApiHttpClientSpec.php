<?php

namespace spec\Snt\Capi\Http;

use Http\Client\Exception\HttpException;
use Http\Client\Exception\TransferException;
use Http\Client\HttpClient as HttpClientInterface;
use Http\Message\RequestFactory as RequestFactoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Snt\Capi\Http\ApiHttpClient;
use Snt\Capi\Http\ApiHttpClientConfiguration;
use Snt\Capi\Http\ApiHttpClientInterface;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\Http\Exception\ApiHttpClientException;
use Snt\Capi\Http\Exception\ApiHttpClientNotFoundException;

/**
 * @mixin ApiHttpClient
 */
class ApiHttpClientSpec extends ObjectBehavior
{
    const API_ENDPOINT = 'endpoint';
    const API_KEY = 'key';
    const API_SECRET = 'secret';
    const API_PATH = 'path';
    const API_QUERY = 'query';

    /**
     * @var ApiHttpClientConfiguration
     */
    private $apiHttpClientConfiguration;

    function let(
        HttpClientInterface $httpClient,
        RequestFactoryInterface $requestFactory
    ) {
        $this->apiHttpClientConfiguration = new ApiHttpClientConfiguration(self::API_ENDPOINT, self::API_KEY, self::API_SECRET);

        $this->beConstructedWith($httpClient, $this->apiHttpClientConfiguration, $requestFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ApiHttpClient::class);
        $this->shouldImplement(ApiHttpClientInterface::class);
    }

    function it_makes_http_get_request(
        HttpClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        RequestInterface $request,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $expectedResponse = 'response';

        $apiHttpPathAndQuery = ApiHttpPathAndQuery::createForPathAndQuery(self::API_PATH, self::API_QUERY);

        $uri = sprintf('%s/%s', self::API_ENDPOINT, $apiHttpPathAndQuery->getPathAndQuery());

        $requestFactory->createRequest(
            ApiHttpClient::GET_REQUEST,
            $uri,
            $this->apiHttpClientConfiguration->buildHeaders()
        )->shouldBeCalled()->willReturn($request);

        $httpClient->sendRequest($request)->willReturn($response);

        $response->getBody()->willReturn($stream);
        $response->getStatusCode()->willReturn(200);

        $stream->getContents()->willReturn($expectedResponse);

        $this->get($apiHttpPathAndQuery)->shouldReturn($expectedResponse);
    }

    function it_throws_exception_when_get_request_fails(
        HttpClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        RequestInterface $request
    ) {
        $apiHttpPathAndQuery = ApiHttpPathAndQuery::createForPath(self::API_PATH);

        $requestFactory->createRequest(Argument::any(), Argument::any(), Argument::any())->willReturn($request);

        $httpClient->sendRequest($request)->willThrow(TransferException::class);

        $this->shouldThrow(ApiHttpClientException::class)->duringGet($apiHttpPathAndQuery);
    }

    function it_throws_exception_when_request_returns_not_found_error(
        HttpClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        RequestInterface $request,
        ResponseInterface $response,
        HttpException $httpException
    ) {
        $apiHttpPathAndQuery = ApiHttpPathAndQuery::createForPath(self::API_PATH);

        $response->getStatusCode()->willReturn(404);

        $requestFactory->createRequest(Argument::any(), Argument::any(), Argument::any())->willReturn($request);

        $httpException->getResponse()->willReturn($response);

        $httpClient->sendRequest($request)->willThrow($httpException->getWrappedObject());

        $this->shouldThrow(ApiHttpClientNotFoundException::class)->duringGet($apiHttpPathAndQuery);
    }
}
