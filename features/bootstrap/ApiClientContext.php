<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase as PhpUnit;
use Snt\Capi\ApiClient;
use Snt\Capi\ApiClientConfiguration;
use Snt\Capi\Http\HttpClientInterface;

class ApiClientContext implements Context, SnippetAcceptingContext
{
    const ARTICLE_NOT_FOUND_EXCEPTION_MESSAGE = "Article for publication '%s' with '%s' not found";

    const ARTICLE_PATH_PATTERN = 'publication/%s/articles/%s';

    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @var array
     */
    private $articles;

    /**
     * @var array
     */
    private $articlesFromApi = [];

    /**
     * @var HttpClientInterface|MockInterface
     */
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = Mockery::mock(HttpClientInterface::class);
    }

    /**
     * @Transform table:article_id
     *
     * @param TableNode $articleIds
     *
     * @return array
     */
    public function castArticleIds(TableNode $articleIds)
    {
        return array_column($articleIds->getColumnsHash(), 'article_id');
    }

    /**
     * @When I create API Client with :endpoint endpoint and :apiKey api key and :apiSecret api secret
     *
     * @param string $endpoint
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function iCreateApiClientWithEndpointAndApiKeyAndApiSecret($endpoint, $apiKey, $apiSecret)
    {
        $this->apiClient = new ApiClient(
            new ApiClientConfiguration($endpoint, $apiKey, $apiSecret)
        );

        $this->apiClient->setHttpClient($this->httpClient);
    }

    /**
     * @When I ask for :articleId article for :publicationId publication using API Client
     *
     * @param string $articleId
     * @param string $publicationId
     */
    public function iAskForArticleForPublicationUsingApiClient($articleId, $publicationId)
    {
        $articleRepository = $this->apiClient->getArticleRepositoryForPublication($publicationId);

        $this->articles[$articleId] = $articleRepository->find($articleId);
    }

    /**
     * @Then I should get :articleId article for :publicationId publication with content from API
     *
     * @param string $articleId
     * @param string $publicationId
     *
     * @throws RuntimeException
     */
    public function iShouldGetArticleForPublicationWithContentFromApi($articleId, $publicationId)
    {
        if (isset($this->articlesFromApi[$publicationId][$articleId])) {
            $articleArray = $this->articlesFromApi[$publicationId][$articleId];

            $article = $this->articles[$articleId];

            foreach ($articleArray as $field => $value) {
                PhpUnit::assertEquals($value, $article[$field]);
            }
        } else {
            $message = sprintf(
                self::ARTICLE_NOT_FOUND_EXCEPTION_MESSAGE,
                $publicationId,
                $articleId
            );

            throw new RuntimeException($message);
        }
    }

    /**
     * @Given there is :articleId article for :publicationId publication:
     *
     * @param string $articleId
     * @param string $publicationId
     * @param PyStringNode $apiResponse
     */
    public function thereIsArticleForPublication($articleId, $publicationId, PyStringNode $apiResponse)
    {
        $this->articlesFromApi[$publicationId][$articleId] = json_decode($apiResponse->getRaw(), true);

        $this->httpClient
            ->shouldReceive('get')
            ->with(sprintf(self::ARTICLE_PATH_PATTERN, $publicationId, $articleId))
            ->andReturn($apiResponse->getRaw());
    }

    /**
     * @Given there are articles for :publicationId publication:
     *
     * @param string $publicationId
     * @param PyStringNode $apiResponse
     */
    public function thereAreArticlesForPublication($publicationId, PyStringNode $apiResponse)
    {
        $articlesApiResponse = json_decode($apiResponse->getRaw(), true);

        foreach ($articlesApiResponse['articles'] as $article) {
            $this->articlesFromApi[$publicationId][$article['id']] = $article;
        }

        $articleIds = array_column(
            $articlesApiResponse['articles'],
            'id'
        );

        $this->httpClient
            ->shouldReceive('get')
            ->with(sprintf(self::ARTICLE_PATH_PATTERN, $publicationId, implode(',', $articleIds)))
            ->andReturn($apiResponse->getRaw());
    }

    /**
     * @When I ask for articles for :publicationId publication using API Client:
     *
     * @param string $publicationId
     * @param array $articleIds
     */
    public function iAskForArticlesForPublicationUsingApiClient($publicationId, array $articleIds)
    {
        $articleRepository = $this->apiClient->getArticleRepositoryForPublication($publicationId);

        foreach ($articleRepository->findByIds($articleIds) as $article) {
            $this->articles[$article['id']] = $article;
        };
    }
}
