<?php

namespace Snt\Capi;

use GuzzleHttp\Client as GuzzleClient;
use Snt\Capi\Http\HttpClient;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\ArticleRepository;
use Snt\Capi\Repository\ArticleRepositoryInterface;

class ApiClient
{
    /**
     * @var ApiClientConfiguration
     */
    protected $clientConfiguration;

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @param ApiClientConfiguration $clientConfiguration
     */
    public function __construct(ApiClientConfiguration $clientConfiguration)
    {
        $this->clientConfiguration = $clientConfiguration;

        $this->httpClient = new HttpClient(
            $this->clientConfiguration,
            new GuzzleClient()
        );
    }

    /**
     * @param string $publicationId
     *
     * @return ArticleRepositoryInterface
     */
    public function getArticleRepositoryForPublication($publicationId)
    {
        $articleRepository = new ArticleRepository($this->httpClient);

        $articleRepository->setPublicationId($publicationId);

        return $articleRepository;
    }

    /**
     * @param HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }
}
