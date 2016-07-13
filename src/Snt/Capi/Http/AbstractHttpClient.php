<?php

namespace Snt\Capi\Http;

abstract class AbstractHttpClient implements HttpClientInterface
{
    /**
     * @var HttpClientConfiguration
     */
    protected $httpClientConfiguration;

    /**
     * @param HttpClientConfiguration $httpClientConfiguration
     */
    public function __construct(HttpClientConfiguration $httpClientConfiguration)
    {
        $this->httpClientConfiguration = $httpClientConfiguration;
    }
}
