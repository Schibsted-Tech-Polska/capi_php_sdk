<?php

namespace spec\Snt\Capi\Http\Guzzle;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Snt\Capi\Http\Exception\CouldNotMakeHttpGetRequest;
use Snt\Capi\Http\Guzzle\HttpClient;
use Snt\Capi\Http\HttpClientConfiguration;
use Snt\Capi\Http\HttpClientInterface;

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
        ClientInterface $client
    ) {
        $httpClientConfiguration = new HttpClientConfiguration(self::ENDPOINT, self::API_KEY, self::API_SECRET);
        $this->beConstructedWith($httpClientConfiguration, $client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HttpClient::class);
        $this->shouldImplement(HttpClientInterface::class);
    }

    function it_makes_http_get_request_using_guzzle_client(
        ClientInterface $client,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $expectedResponse = 'response';

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

    function it_throws_exception_when_get_request_fails(
        ClientInterface $client
    ) {
        $client->request(Argument::any(), Argument::any(), Argument::any())->willThrow(TransferException::class);

        $this->shouldThrow(CouldNotMakeHttpGetRequest::class)->duringGet(self::PATH);
    }
}
