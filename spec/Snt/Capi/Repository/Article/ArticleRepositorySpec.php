<?php

namespace spec\Snt\Capi\Repository\Article;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Snt\Capi\Http\ApiHttpClientInterface;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\Http\Exception\ApiHttpClientException;
use Snt\Capi\Http\Exception\ApiHttpClientNotFoundException;
use Snt\Capi\PublicationId;
use Snt\Capi\Repository\AbstractRepository;
use Snt\Capi\Repository\Article\ArticleRepository;
use Snt\Capi\Repository\Article\ArticleRepositoryInterface;
use Snt\Capi\Repository\Article\FindByChangelogParameters;
use Snt\Capi\Repository\Article\FindByIdsParameters;
use Snt\Capi\Repository\Article\FindBySectionParameters;
use Snt\Capi\Repository\Article\FindParameters;
use Snt\Capi\Repository\Article\FindWithQueryParameters;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;
use Snt\Capi\Repository\Response;

/**
 * @mixin ArticleRepository
 */
class ArticleRepositorySpec extends ObjectBehavior
{
    const ARTICLE_ID = '123';

    const ARTICLE_PATH_PATTERN = 'publication/%s/articles/%s';

    const ARTICLES_CHANGELOG_PATH_PATTERN = 'changelog/%s/search';

    const ARTICLES_FROM_SECTION_PATH_PATTERN = 'publication/%s/sections/%s/latest';

    const ARTICLES_WITH_QUERY_PATH_PATTERN = 'publication/%s/searchContents/search';

    const ARTICLE_RAW_DATA = '';

    const NO_EXISTING_ARTICLE_ID = '-1';

    const QUERY = 'mablis';

    const SECTION_NAME = 'bolig';

    function let(ApiHttpClientInterface $apiHttpClient)
    {
        $this->beConstructedWith($apiHttpClient, PublicationId::SA);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AbstractRepository::class);
        $this->shouldHaveType(ArticleRepository::class);
        $this->shouldImplement(ArticleRepositoryInterface::class);
    }

    function it_finds_article_by_id_for_publication_id(
        ApiHttpClientInterface $apiHttpClient
    ) {
        $path = sprintf(self::ARTICLE_PATH_PATTERN, PublicationId::SA, self::ARTICLE_ID);

        $apiHttpPathAndQuery = ApiHttpPathAndQuery::createForPath($path);

        $apiHttpClient->get($apiHttpPathAndQuery)->shouldBeCalled()->willReturn('{"id":123,"title": "some text"}');

        $findParameters = FindParameters::createForPublicationIdAndArticleId(PublicationId::SA, self::ARTICLE_ID);

        $expectedResponse = Response::createFrom([
            'id' => 123,
            'title' => 'some text',
        ]);

        $this->find($findParameters)->shouldBeLike($expectedResponse);
    }

    function it_returns_null_for_searching_by_article_id_when_http_client_returns_not_found(
        ApiHttpClientInterface $apiHttpClient
    ) {
        $apiHttpClient->get(Argument::type(ApiHttpPathAndQuery::class))->willThrow(
            new ApiHttpClientNotFoundException()
        );

        $findParameters = FindParameters::createForPublicationIdAndArticleId(PublicationId::SA, self::NO_EXISTING_ARTICLE_ID);

        $this->find($findParameters)->shouldBeLike(Response::createFrom(null));
    }

    function it_finds_articles_by_ids_for_publication_id(ApiHttpClientInterface $apiHttpClient)
    {
        $expectedArticles = [
            'articles' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
            ],
        ];

        $path = sprintf(self::ARTICLE_PATH_PATTERN, PublicationId::SA, '1,2,3');

        $apiHttpPathAndQuery = ApiHttpPathAndQuery::createForPath($path);

        $apiHttpClient->get($apiHttpPathAndQuery)->shouldBeCalled()->willReturn('{"articles":[{"id":1},{"id":2},{"id":3}]}');

        $findParameters = FindByIdsParameters::createForPublicationIdAndArticleIds(PublicationId::SA, [1,2,3]);

        $this->findByIds($findParameters)->shouldBeLike(Response::createFrom($expectedArticles));
    }

    function it_finds_articles_changelog_for_publication_id(
        ApiHttpClientInterface $apiHttpClient
    ) {
        $expectedArticles = [
            '_links' => [],
            'articles' => [
                ['id' => 1],
                ['id' => 2],
            ],
            'totalArticles' => 2,
        ];

        $path = sprintf(self::ARTICLES_CHANGELOG_PATH_PATTERN, PublicationId::SA);

        $apiHttpPathAndQuery = ApiHttpPathAndQuery::createForPath($path);

        $apiHttpClient->get($apiHttpPathAndQuery)->shouldBeCalled()->willReturn('{"_links": {}, "articles":[{"id":"1"},{"id":"2"}],"totalArticles":"2"}');

        $findParameters = FindByChangelogParameters::createForPublicationId(PublicationId::SA);

        $this->findByChangelog($findParameters)->shouldBeLike(Response::createFrom($expectedArticles));
    }

    function it_finds_articles_by_section_for_publication_id(ApiHttpClientInterface $apiHttpClient)
    {
        $expectedArticles = [
            'teasers' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
            ],
        ];

        $path = sprintf(self::ARTICLES_FROM_SECTION_PATH_PATTERN, PublicationId::SA, self::SECTION_NAME);

        $apiHttpPathAndQuery = ApiHttpPathAndQuery::createForPath($path);

        $apiHttpClient->get($apiHttpPathAndQuery)->willReturn('{"teasers":[{"id":1},{"id":2},{"id":3}]}');

        $findParameters = FindBySectionParameters::createForPublicationIdAndSections(
            PublicationId::SA,
            [self::SECTION_NAME]
        );

        $this->findBySections($findParameters)->shouldBeLike(Response::createFrom($expectedArticles));
    }

    function it_finds_articles_with_query(ApiHttpClientInterface $apiHttpClient)
    {
        $expectedArticles = [
            'teasers' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
            ],
        ];

        $path = sprintf(self::ARTICLES_WITH_QUERY_PATH_PATTERN, PublicationId::SA);

        $apiHttpPathAndQuery = ApiHttpPathAndQuery::createForPathAndQuery($path, 'query=mablis');

        $apiHttpClient->get($apiHttpPathAndQuery)->willReturn('{"teasers":[{"id":1},{"id":2},{"id":3}]}');

        $findParameters = FindWithQueryParameters::createForPublicationIdAndQuery(PublicationId::SA, self::QUERY);

        $this->findWithQuery($findParameters)->shouldBeLike(Response::createFrom($expectedArticles));
    }

    function it_throws_exception_when_can_not_fetch_response_using_http_client(
        ApiHttpClientInterface $apiHttpClient
    ) {
        $apiHttpClient->get(Argument::type(ApiHttpPathAndQuery::class))->willThrow(ApiHttpClientException::class);

        $this
            ->shouldThrow(CouldNotFetchResourceRepositoryException::class)
            ->duringFindByIds(
                FindByIdsParameters::createForPublicationIdAndArticleIds(PublicationId::SA, [self::ARTICLE_ID])
            );

        $this
            ->shouldThrow(CouldNotFetchResourceRepositoryException::class)
            ->duringFind(
                FindParameters::createForPublicationIdAndArticleId(PublicationId::SA, self::ARTICLE_ID)
            );

        $this
            ->shouldThrow(CouldNotFetchResourceRepositoryException::class)
            ->duringFindByChangelog(
                FindByChangelogParameters::createForPublicationId(PublicationId::SA)
            );

        $this->shouldThrow(CouldNotFetchResourceRepositoryException::class)
            ->duringFindBySections(
                FindBySectionParameters::createForPublicationIdAndSections(PublicationId::SA, [self::SECTION_NAME])
            );

        $this->shouldThrow(CouldNotFetchResourceRepositoryException::class)
            ->duringFindWithQuery(
                FindWithQueryParameters::createForPublicationIdAndQuery(PublicationId::SA, self::QUERY)
            );
    }
}
