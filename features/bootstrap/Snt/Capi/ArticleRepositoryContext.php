<?php

namespace Snt\Capi;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use DateTime;
use Mockery;
use PHPUnit_Framework_TestCase as PhpUnit;
use PHPUnit_Framework_ExpectationFailedException as PhpUnitExpectationFailedException;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Http\HttpRequestParameters;
use Snt\Capi\Repository\Article\ArticleRepository;
use Snt\Capi\Repository\Article\ArticleRepositoryInterface;
use Snt\Capi\Repository\Article\FindParameters;
use Snt\Capi\Repository\TimeRangeParameter;

class ArticleRepositoryContext implements Context, SnippetAcceptingContext
{
    const ARTICLE_PATH_PATTERN = 'publication/%s/articles/%s';

    const ARTICLES_CHANGELOG_PATH_PATTERN = 'changelog/%s/search';

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
     * @var array
     */
    private $articleChangelogFromApi;

    /**
     * @var array
     */
    private $articlesChangelog;

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
     * @Transform :until
     * @Transform :since
     *
     * @param string $dateString
     *
     * @return DateTime
     */
    public function transformStringToDateTime($dateString)
    {
        return new DateTime($dateString);
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
        $findParameters = FindParameters::createForPublicationIdAndArticleId($publicationId, $articleId);

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
        $findParameters = FindParameters::createForPublicationIdAndArticleIds($publicationId, $articleIds);

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
     * @throws PhpUnitExpectationFailedException
     */
    public function iShouldGetArticleForPublicationWithContentFromApi($articleId, $publicationId)
    {
        PhpUnit::assertEquals($this->articlesFromApi[$publicationId][$articleId], $this->articles[$articleId]);
    }

    /**
     * @Given there is :articleId article for :publicationId publication in API:
     *
     * @param string $articleId
     * @param string $publicationId
     * @param PyStringNode $apiResponse
     */
    public function thereIsArticleForPublicationInApi($articleId, $publicationId, PyStringNode $apiResponse)
    {
        $this->articlesFromApi[$publicationId][$articleId] = json_decode($apiResponse->getRaw(), true);

        $path = sprintf(self::ARTICLE_PATH_PATTERN, $publicationId, $articleId);

        $this->httpClient
            ->shouldReceive('get')
            ->with(Mockery::on(function (HttpRequestParameters $httpRequestParameters) use ($path) {
                return $httpRequestParameters == HttpRequestParameters::createForPath($path);
            }))
            ->andReturn($apiResponse->getRaw());
    }

    /**
     * @Given there are articles for :publicationId publication in API:
     *
     * @param string $publicationId
     * @param PyStringNode $apiResponse
     */
    public function thereAreArticlesForPublicationInApi($publicationId, PyStringNode $apiResponse)
    {
        $articlesApiResponse = json_decode($apiResponse->getRaw(), true);

        foreach ($articlesApiResponse['articles'] as $article) {
            $this->articlesFromApi[$publicationId][$article['id']] = $article;
        }

        $articleIds = array_column(
            $articlesApiResponse['articles'],
            'id'
        );

        $path = sprintf(self::ARTICLE_PATH_PATTERN, $publicationId, implode(',', $articleIds));

        $this->httpClient
            ->shouldReceive('get')
            ->with(Mockery::on(function (HttpRequestParameters $httpRequestParameters) use ($path) {
                return $httpRequestParameters == HttpRequestParameters::createForPath($path);
            }))
            ->andReturn($apiResponse->getRaw());
    }

    /**
     * @Given there is articles changelog for :publicationId publication in API:
     *
     * @param string $publicationId
     * @param PyStringNode $changelogFromApi
     */
    public function thereIsArticlesChangelogForPublicationInApi($publicationId, PyStringNode $changelogFromApi)
    {
        $articlesChangeFromApi = str_replace('PUBLICATION_ID', $publicationId, $changelogFromApi->getRaw());

        $changelogApiResponse = json_decode($articlesChangeFromApi, true);

        $this->articleChangelogFromApi[$publicationId] = $changelogApiResponse;

        $path = sprintf(self::ARTICLES_CHANGELOG_PATH_PATTERN, $publicationId);

        $this->httpClient
            ->shouldReceive('get')
            ->with(Mockery::on(function (HttpRequestParameters $httpRequestParameters) use ($path) {
                return $httpRequestParameters == HttpRequestParameters::createForPath($path);
            }))
            ->andReturn($articlesChangeFromApi);
    }

    /**
     * @When I ask for articles changelog for :publicationId publication using article repository
     *
     * @param string $publicationId
     */
    public function iAskForArticlesChangelogForPublicationUsingArticleRepository($publicationId)
    {
        $findParameters = FindParameters::createForPublicationId($publicationId);

        $this->articlesChangelog[$publicationId] = $this->articleRepository->findByChangelog($findParameters);
    }

    /**
     * @Then I should get articles changelog for :publicationId publication with content from API
     *
     * @param string $publicationId
     *
     * @throws PhpUnitExpectationFailedException
     */
    public function iShouldGetArticlesChangelogForPublicationWithContentFromApi($publicationId)
    {
        PhpUnit::assertEquals($this->articleChangelogFromApi[$publicationId], $this->articlesChangelog[$publicationId]);
    }

    /**
     * @codingStandardsIgnoreStart
     * @Given there is articles changelog for :publicationId publication with time range since :since until :until and :limit limit in API:
     * @codingStandardsIgnoreEnd
     *
     * @param string $publicationId
     * @param DateTime $since
     * @param DateTime $until
     * @param string $limit
     * @param PyStringNode $changelogFromApi
     */
    public function thereIsArticlesChangelogForPublicationWithTimeRangeFromToAndLimitInApi(
        $publicationId,
        DateTime $since,
        DateTime $until,
        $limit,
        PyStringNode $changelogFromApi
    ) {
        $articlesChangeFromApi = str_replace('PUBLICATION_ID', $publicationId, $changelogFromApi);

        $changelogApiResponse = json_decode($articlesChangeFromApi, true);

        $this->articleChangelogFromApi[$publicationId] = $changelogApiResponse;

        $path = sprintf(self::ARTICLES_CHANGELOG_PATH_PATTERN, $publicationId);

        $query = http_build_query([
            'limit' => $limit,
            'since' => $since->format('Y-m-d H:i:s'),
            'until' => $until->format('Y-m-d H:i:s'),
        ]);

        $this->httpClient
            ->shouldReceive('get')
            ->with(Mockery::on(function (HttpRequestParameters $httpRequestParameters) use ($path, $query) {
                return $httpRequestParameters == HttpRequestParameters::createForPathAndQuery($path, $query);
            }))
            ->andReturn($articlesChangeFromApi);
    }

    /**
     * @codingStandardsIgnoreStart
     * @When I ask for articles changelog for :publicationId publication with time range from :since to :until and :limit limit using article repository
     * @codingStandardsIgnoreEnd
     *
     * @param string $publicationId
     * @param DateTime $since
     * @param DateTime $until
     * @param string $limit
     */
    public function iAskForArticlesChangelogForPublicationWithTimeRangeFromToAndLimitUsingArticleRepository(
        $publicationId,
        DateTime $since,
        DateTime $until,
        $limit
    ) {
        $timeRange = new TimeRangeParameter($since, $until);

        $findParameters = FindParameters::createForPublicationIdWithTimeRangeAndLimit(
            $publicationId,
            $timeRange,
            $limit
        );

        $this->articlesChangelog[$publicationId] = $this->articleRepository->findByChangelog($findParameters);
    }
}
