<?php

namespace Snt\Capi;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Mockery;
use PHPUnit_Framework_TestCase as PhpUnit;
use RuntimeException;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\Article\ArticleRepository;
use Snt\Capi\Repository\Article\ArticleRepositoryInterface;
use Snt\Capi\Repository\Article\FindParameters;

class ArticleRepositoryContext implements Context, SnippetAcceptingContext
{
    const ARTICLE_NOT_FOUND_EXCEPTION_MESSAGE = "Article for publication '%s' with '%s' not found";

    const ARTICLE_PATH_PATTERN = 'publication/%s/articles/%s';

    /**
     * @var array
     */
    private $articles = [];

    /**
     * @var array
     */
    private $articlesFromApi = [];

    /**
     * @var ArticleRepositoryInterface
     */
    private $articleRepository;

    /**
     * @var Mockery
     */
    private $httpClient;

    /**
     * ArticleRepositoryContext constructor.
     */
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
     * @When I create article repository
     */
    public function iCreateArticleRepository()
    {
        $this->articleRepository = new ArticleRepository($this->httpClient);
    }

    /**
     * @When I ask for :articleId article for :publicationId publication using article repository
     *
     * @param string $articleId
     * @param string $publicationId
     */
    public function iAskForArticleForPublicationUsingArticleRepository($articleId, $publicationId)
    {
        $findParameters = FindParameters::createForPublicationAndArticleId($publicationId, $articleId);

        $this->articles[$articleId] = $this->articleRepository->find($findParameters);
    }

    /**
     * @When I ask for articles for :publicationId publication using article repository:
     *
     * @param string $publicationId
     * @param array $articleIds
     */
    public function iAskForArticlesForPublicationUsingArticleRepository($publicationId, array $articleIds)
    {
        $findParameters = FindParameters::createForPublicationAndArticleIds($publicationId, $articleIds);

        foreach ($this->articleRepository->findByIds($findParameters) as $article) {
            $this->articles[$article['id']] = $article;
        };
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
}
