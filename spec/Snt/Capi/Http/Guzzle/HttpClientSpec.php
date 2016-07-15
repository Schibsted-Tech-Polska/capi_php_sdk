<?php

namespace spec\Snt\Capi\Http\Guzzle;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Snt\Capi\Http\AbstractHttpClient;
use Snt\Capi\Http\Exception\HttpException;
use Snt\Capi\Http\Guzzle\HttpClient;
use Snt\Capi\Http\HttpClientConfiguration;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Http\HttpRequestParameters;

/**
 * @mixin HttpClient
 */
class HttpClientSpec extends ObjectBehavior
{
    const ENDPOINT = 'endpoint';

    const API_KEY = 'apiKey';

    const API_SECRET = 'apiSecret';

    const PATH = 'path';

    const QUERY = 'query';

    function let(
        ClientInterface $client
    ) {
        $httpClientConfiguration = new HttpClientConfiguration(self::ENDPOINT, self::API_KEY, self::API_SECRET);
        $this->beConstructedWith($httpClientConfiguration, $client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HttpClient::class);
        $this->shouldHaveType(AbstractHttpClient::class);
        $this->shouldImplement(HttpClientInterface::class);
    }

    function it_makes_http_get_request_using_guzzle_client(
        ClientInterface $client,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $httpRequestParameters = HttpRequestParameters::createForPathAndQuery(self::PATH, self::QUERY);

        $expectedResponse = 'response';

        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn($expectedResponse);

        $client->request(
            'GET',
            sprintf('%s/%s?%s', self::ENDPOINT, self::PATH, self::QUERY),
            [
                'headers' => [
                    'X-Snd-ApiKey' => self::API_KEY,
                    'X-Snd-ApiSignature' => self::API_SECRET,
                ],
            ]
        )->shouldBeCalled()->willReturn($response);

        $this->get($httpRequestParameters)->shouldReturn($expectedResponse);
    }

    function it_throws_http_exception_when_get_request_fails(
        ClientInterface $client
    ) {
        $httpRequestParameters = HttpRequestParameters::createForPath(self::PATH);

        $client->request(Argument::any(), Argument::any(), Argument::any())->willThrow(TransferException::class);

        $this->shouldThrow(HttpException::class)->duringGet($httpRequestParameters);
    }
}
