<?php

namespace Snt\Capi;

use Snt\Capi\Repository\ArticleRepository;
use Snt\Capi\Repository\ArticleRepositoryInterface;

class Client
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
     * @param string $publicationName
     *
     * @return ArticleRepositoryInterface
     */
    public function getArticleRepository($publicationName)
    {
        return new ArticleRepository($publicationName);
    }
}
