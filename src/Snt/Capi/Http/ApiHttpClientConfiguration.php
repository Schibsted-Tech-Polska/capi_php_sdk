<?php

namespace Snt\Capi\Http;

use DateTime;
use DateTimeZone;
use InvalidArgumentException;

final class ApiHttpClientConfiguration
{
    const API_KEY_HEADER = 'X-Snd-ApiKey';

    const API_SIGNATURE_HEADER = 'X-Snd-ApiSignature';

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $apiSecret;

    /**
     * @param string $endpoint
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct($endpoint, $apiKey, $apiSecret)
    {
        $this->endpoint = $endpoint;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * @param array $config
     *
     * @return ApiHttpClientConfiguration
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $config)
    {
        foreach (['endpoint', 'apiKey', 'apiSecret'] as $key) {
            if (empty($config[$key])) {
                throw new InvalidArgumentException(sprintf('Missing config parameter "%s"', $key));
            }
        }

        return new self($config['endpoint'], $config['apiKey'], $config['apiSecret']);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }

    /**
     * @param ApiHttpPathAndQuery $apiHttpPathAndQuery
     *
     * @return string
     */
    public function buildUri(ApiHttpPathAndQuery $apiHttpPathAndQuery)
    {
        return sprintf('%s/%s', $this->endpoint, $apiHttpPathAndQuery->getPathAndQuery());
    }

    /**
     * @return array
     */
    public function buildHeaders()
    {
        $now = new DateTime('now', new DateTimeZone('UTC'));

        $signature = sprintf('0x%s', hash_hmac('sha256', $now->format('d M Y H'), $this->apiSecret));

        return [
            self::API_KEY_HEADER => $this->apiKey,
            self::API_SIGNATURE_HEADER => $signature,
        ];
    }
}
