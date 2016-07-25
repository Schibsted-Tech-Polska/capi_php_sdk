<?php

namespace spec\Snt\Capi\Http;

use DateTime;
use DateTimeZone;
use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\ApiHttpClientConfiguration;
use Snt\Capi\Http\ApiHttpPathAndQuery;

/**
 * @mixin ApiHttpClientConfiguration
 */
class ApiHttpClientConfigurationSpec extends ObjectBehavior
{
    const API_ENDPOINT = 'endpoint';
    const API_SECRET = 'secret';
    const API_KEY = 'key';
    const API_PATH = 'path';
    const API_QUERY = 'a=2&3=2';

    function let()
    {
        $this->beConstructedWith(self::API_ENDPOINT, self::API_KEY, self::API_SECRET);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ApiHttpClientConfiguration::class);
    }

    function it_delivers_information_about_configuration()
    {
        $this->getApiKey()->shouldReturn(self::API_KEY);
        $this->getApiSecret()->shouldReturn(self::API_SECRET);
        $this->getEndpoint()->shouldReturn(self::API_ENDPOINT);
    }

    function it_builds_api_client_uri()
    {
        $expectedUri = sprintf('%s/%s?%s', self::API_ENDPOINT, self::API_PATH, self::API_QUERY);

        $apiHttpPathAndQuery = ApiHttpPathAndQuery::createForPathAndQuery(self::API_PATH, self::API_QUERY);

        $this->buildUri($apiHttpPathAndQuery)->shouldReturn($expectedUri);
    }

    function it_builds_api_client_headers()
    {
        $now = new DateTime('now', new DateTimeZone('UTC'));

        $signature = sprintf('0x%s', hash_hmac('sha256', $now->format('d M Y H'), self::API_SECRET));

        $expectedHeaders = [
            ApiHttpClientConfiguration::API_KEY_HEADER => self::API_KEY,
            ApiHttpClientConfiguration::API_SIGNATURE_HEADER => $signature,
        ];

        $this->buildHeaders()->shouldReturn($expectedHeaders);
    }
}
