<?php

namespace Snt\Capi;

use Snt\Capi\Http\HttpClientConfigurationInterface;

final class ApiClientConfiguration implements HttpClientConfigurationInterface
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecret;

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
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }
}
