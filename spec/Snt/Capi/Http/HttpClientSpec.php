<?php

namespace spec\Snt\Capi\Http;

use GuzzleHttp\ClientInterface;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Snt\Capi\Http\HttpClient;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Http\HttpClientConfigurationInterface;

/**
 * @mixin HttpClient
 */
class HttpClientSpec extends ObjectBehavior
{
    const ENDPOINT = 'endpoint';

    const API_KEY = 'apiKey';

    const API_SECRET = 'apiSecret';

    const PATH = 'path';

    function let(
        HttpClientConfigurationInterface $httpClientConfiguration,
        ClientInterface $client
    ) {
        $this->beConstructedWith($httpClientConfiguration, $client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HttpClient::class);
        $this->shouldImplement(HttpClientInterface::class);
    }

    function it_makes_http_get_request_using_guzzle_client(
        HttpClientConfigurationInterface $httpClientConfiguration,
        ClientInterface $client,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $expectedResponse = 'response';

        $httpClientConfiguration->getEndpoint()->willReturn(self::ENDPOINT);
        $httpClientConfiguration->getApiKey()->willReturn(self::API_KEY);
        $httpClientConfiguration->getApiSecret()->willReturn(self::API_SECRET);

        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn($expectedResponse);

        $client->request(
            'GET',
            sprintf('%s/%s', self::ENDPOINT, self::PATH),
            [
                'headers' => [
                    'X-Snd-ApiKey' => self::API_KEY,
                    'X-Snd-ApiSignature' => self::API_SECRET,
                ],
            ]
        )->shouldBeCalled()->willReturn($response);

        $this->get(self::PATH)->shouldReturn($expectedResponse);
    }
}
