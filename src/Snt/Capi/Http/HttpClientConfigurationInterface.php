<?php

namespace Snt\Capi\Http;

interface HttpClientConfigurationInterface
{
    /**
     * @return string
     */
    public function getEndpoint();

    /**
     * @return string
     */
    public function getApiKey();

    /**
     * @return string
     */
    public function getApiSecret();
}
