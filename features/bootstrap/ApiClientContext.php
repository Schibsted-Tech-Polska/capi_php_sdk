<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase as PhpUnit;
use Snt\Capi\ApiClient;
use Snt\Capi\ApiClientConfiguration;
use Snt\Capi\Entity\Article;
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
     * @var Article
     */
    private $article;

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
        $articleRepository = $this->apiClient->getArticleRepository();

        $this->article = $articleRepository->find($publicationId, $articleId);
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
            $articleArray = json_decode($this->articlesFromApi[$publicationId][$articleId]);

            $article = $this->article->getRawData();

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
     * @param PyStringNode $string
     */
    public function thereIsArticleForPublication($articleId, $publicationId, PyStringNode $string)
    {
        $this->articlesFromApi[$publicationId][$articleId] = $string->getRaw();

        $this->httpClient
            ->shouldReceive('get')
            ->with(sprintf(self::ARTICLE_PATH_PATTERN, $publicationId, $articleId))
            ->andReturn($string->getRaw());
    }
}
