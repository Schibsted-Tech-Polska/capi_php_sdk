<?php

namespace spec\Snt\Capi\Repository\Article;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Snt\Capi\Http\Exception\HttpException;
use Snt\Capi\Http\Exception\HttpExceptionReason;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\PublicationId;
use Snt\Capi\Repository\Article\ArticleRepository;
use Snt\Capi\Repository\Article\ArticleRepositoryInterface;
use Snt\Capi\Repository\Article\FindParameters;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;

/**
 * @mixin ArticleRepository
 */
class ArticleRepositorySpec extends ObjectBehavior
{
    const ARTICLE_ID = '123';

    const ARTICLE_PATH_PATTERN = 'publication/%s/articles/%s';

    const ARTICLE_RAW_DATA = '';

    const NO_EXISTING_ARTICLE_ID = '-1';

    function let(HttpClientInterface $httpClient)
    {
        $this->beConstructedWith($httpClient, PublicationId::SA);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ArticleRepository::class);
        $this->shouldImplement(ArticleRepositoryInterface::class);
    }

    function it_finds_article_by_id_for_publication_id(
        HttpClientInterface $httpClient
    ) {
        $path = sprintf(self::ARTICLE_PATH_PATTERN, PublicationId::SA, self::ARTICLE_ID);

        $httpClient->get($path)->shouldBeCalled()->willReturn('{"id":123,"title": "some text"}');

        $findParameters = FindParameters::createForPublicationIdAndArticleId(PublicationId::SA, self::ARTICLE_ID);

        $this->find($findParameters)->shouldBe([
            'id' => 123,
            'title' => 'some text',
        ]);
    }

    function it_returns_null_for_searching_by_article_id_when_http_client_returns_not_found(
        HttpClientInterface $httpClient
    ) {
        $httpClient->get(Argument::any())->willThrow(
            new HttpException(
                'message',
                0,
                null,
                HttpExceptionReason::createForNotFoundError()
            )
        );

        $findParameters = FindParameters::createForPublicationIdAndArticleId(PublicationId::SA, self::NO_EXISTING_ARTICLE_ID);

        $this->find($findParameters)->shouldReturn(null);
    }

    function it_finds_articles_by_ids_for_publication_id(HttpClientInterface $httpClient)
    {
        $expectedArticles = [
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
        ];

        $path = sprintf(self::ARTICLE_PATH_PATTERN, PublicationId::SA, '1,2,3');

        $httpClient->get($path)->shouldBeCalled()->willReturn('{"articles":[{"id":"1"},{"id":"2"},{"id":"3"}]}');

        $findParameters = FindParameters::createForPublicationIdAndArticleIds(PublicationId::SA, [1,2,3]);

        $this->findByIds($findParameters)->shouldBeLike($expectedArticles);
    }

    function it_throws_exception_when_can_not_fetch_response_using_http_client(
        HttpClientInterface $httpClient
    ) {
        $httpClient->get(Argument::any())->willThrow(HttpException::class);

        $this
            ->shouldThrow(CouldNotFetchResourceRepositoryException::class)
            ->duringFindByIds(
                FindParameters::createForPublicationIdAndArticleIds(PublicationId::SA, [self::ARTICLE_ID])
            );
        
        $this
            ->shouldThrow(CouldNotFetchResourceRepositoryException::class)
            ->duringFind(
                FindParameters::createForPublicationIdAndArticleId(PublicationId::SA, self::ARTICLE_ID)
            );
    }
}
