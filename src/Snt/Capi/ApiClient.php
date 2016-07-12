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
     * @var ArticleRepositoryInterface
     */
    protected $articleRepository;

    /**
     * @param ApiClientConfiguration $clientConfiguration
     * @param HttpClientInterface|null $httpClient
     * @param ArticleRepositoryInterface|null $articleRepository
     */
    public function __construct(
        ApiClientConfiguration $clientConfiguration,
        HttpClientInterface $httpClient = null,
        ArticleRepositoryInterface $articleRepository = null
    ) {
        $this->clientConfiguration = $clientConfiguration;

        $this->httpClient = $httpClient ? $httpClient : $this->getDefaultHttpClient();

        $this->articleRepository = $articleRepository ? $articleRepository : $this->getDefaultArticleRepository();
    }

    /**
     * @param ArticleRepositoryInterface $articleRepository
     */
    public function setArticleRepository(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @return ArticleRepositoryInterface
     */
    public function getArticleRepository()
    {
        return $this->articleRepository;
    }

    private function getDefaultHttpClient()
    {
        return new HttpClient(
            $this->clientConfiguration,
            new GuzzleClient()
        );

    }

    private function getDefaultArticleRepository()
    {
        return new ArticleRepository($this->httpClient);
    }
}
