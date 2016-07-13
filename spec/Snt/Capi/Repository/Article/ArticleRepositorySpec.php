<?php

namespace spec\Snt\Capi\Repository\Article;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Snt\Capi\Http\Exception\CouldNotMakeHttpGetRequest;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\Article\ArticleRepository;
use Snt\Capi\Repository\Article\ArticleRepositoryInterface;
use Snt\Capi\Repository\Article\Exception\CouldNotFetchArticleRepositoryException;
use Snt\Capi\Repository\Article\FindByIdsParameters;
use Snt\Capi\Repository\Article\FindParameters;

/**
 * @mixin ArticleRepository
 */
class ArticleRepositorySpec extends ObjectBehavior
{
    const ARTICLE_ID = '123';

    const PUBLICATION_ID = 'sa';

    const ARTICLE_PATH_PATTERN = 'publication/%s/articles/%s';

    const ARTICLE_RAW_DATA = '';

    function let(HttpClientInterface $httpClient)
    {
        $this->beConstructedWith($httpClient, self::PUBLICATION_ID);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ArticleRepository::class);
        $this->shouldImplement(ArticleRepositoryInterface::class);
    }

    function it_finds_article_by_its_id(
        HttpClientInterface $httpClient
    ) {
        $path = sprintf(self::ARTICLE_PATH_PATTERN, self::PUBLICATION_ID, self::ARTICLE_ID);

        $httpClient->get($path)->shouldBeCalled()->willReturn('{"id":123,"title": "some text"}');

        $findParameters = FindParameters::createForPublicationAndArticleId(self::PUBLICATION_ID, self::ARTICLE_ID);

        $this->find($findParameters)->shouldBe([
            'id' => 123,
            'title' => 'some text',
        ]);
    }

    function it_finds_articles_by_ids(HttpClientInterface $httpClient)
    {
        $expectedArticles = [
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
        ];

        $path = sprintf(self::ARTICLE_PATH_PATTERN, self::PUBLICATION_ID, '1,2,3');

        $httpClient->get($path)->shouldBeCalled()->willReturn('{"articles":[{"id":"1"},{"id":"2"},{"id":"3"}]}');

        $findByIdsParameters = FindByIdsParameters::createForPublicationAndArticleIds(self::PUBLICATION_ID, [1,2,3]);

        $this->findByIds($findByIdsParameters)->shouldBeLike($expectedArticles);
    }

    function it_throws_exception_when_can_not_fetch_response_using_http_client(
        HttpClientInterface $httpClient
    ) {
        $httpClient->get(Argument::any())->willThrow(CouldNotMakeHttpGetRequest::class);

        $this
            ->shouldThrow(CouldNotFetchArticleRepositoryException::class)
            ->duringFindByIds(
                FindByIdsParameters::createForPublicationAndArticleIds(self::PUBLICATION_ID, [self::ARTICLE_ID])
            );
        
        $this
            ->shouldThrow(CouldNotFetchArticleRepositoryException::class)
            ->duringFind(
                FindParameters::createForPublicationAndArticleId(self::PUBLICATION_ID, self::ARTICLE_ID)
            );
    }
}
