<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Snt\Capi\Client;
use Snt\Capi\Entity\Article;
use PHPUnit_Framework_TestCase as PhpUnit;

class ClientContext implements Context, SnippetAcceptingContext
{
    const ARTICLE_NOT_FOUND_EXCEPTION_MESSAGE = "Article for publication '%s' with '%s' not found";

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Article
     */
    private $article;

    /**
     * @var array
     */
    private $articlesFromApi = [];

    /**
     * @When I create API Client with :endpoint endpoint and :apiKey api key and :apiSecret api secret
     *
     * @param string $endpoint
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function iCreateApiClientWithEndpointAndApiKeyAndApiSecret($endpoint, $apiKey, $apiSecret)
    {
        $this->client = new Client($endpoint, $apiKey, $apiSecret);
    }

    /**
     * @Then I should get API Client with :endpoint endpoint and :apiKey api key and :apiSecret api secret
     *
     * @param string $endpoint
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function iShouldGetApiClientWithEndpointAndApiKeyAndApiSecret($endpoint, $apiKey, $apiSecret)
    {
        PhpUnit::assertEquals($endpoint, $this->client->getEndpoint());
        PhpUnit::assertEquals($apiKey, $this->client->getApiKey());
        PhpUnit::assertEquals($apiSecret, $this->client->getApiSecret());
    }

    /**
     * @When I ask for :articleId article for :publicationName publication using API Client
     *
     * @param string $articleId
     * @param string $publicationName
     */
    public function iAskForArticleForPublicationUsingApiClient($articleId, $publicationName)
    {
        $articleRepository = $this->client->getArticleRepository($publicationName);

        $this->article = $articleRepository->find($articleId);
    }

    /**
     * @Then I should get :articleId article for :publicationName publication with content from API
     *
     * @param string $articleId
     * @param string $publicationName
     *
     * @throws RuntimeException
     */
    public function iShouldGetArticleForPublicationWithContentFromApi($articleId, $publicationName)
    {
        if (isset($this->articlesFromApi[$publicationName][$articleId])) {
            $articleArray = json_decode($this->articlesFromApi[$publicationName][$articleId]);

            foreach ($articleArray as $field => $value) {
                $getterMethod = sprintf('get%s', ucfirst($field));
                
                PhpUnit::assertEquals($value, $this->article->$getterMethod());
            }
        } else {
            $message = sprintf(
                self::ARTICLE_NOT_FOUND_EXCEPTION_MESSAGE,
                $publicationName,
                $articleId
            );

            throw new RuntimeException($message);
        }
    }

    /**
     * @Given there is :articleId article for :publicationName publication:
     *
     * @param string $articleId
     * @param string $publicationName
     * @param PyStringNode $string
     */
    public function thereIsArticleForPublication($articleId, $publicationName, PyStringNode $string)
    {
        $this->articlesFromApi[$publicationName][$articleId] = $string->getRaw();
    }
}
