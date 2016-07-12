<?php

namespace spec\Snt\Capi\Repository;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Snt\Capi\Http\Exception\CouldNotMakeHttpGetRequest;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\ArticleRepository;
use Snt\Capi\Repository\ArticleRepositoryInterface;
use Snt\Capi\Repository\Exception\CouldNotFetchArticleRepositoryException;

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
        $this->beConstructedWith($httpClient);
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
        $this->setPublicationId(self::PUBLICATION_ID);

        $this->find(self::ARTICLE_ID)->shouldBe([
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
        $this->setPublicationId(self::PUBLICATION_ID);

        $this->findByIds([1,2,3])->shouldBeLike($expectedArticles);
    }

    function it_throws_exception_when_can_not_fetch_response_using_http_client(
        HttpClientInterface $httpClient
    ) {
        $httpClient->get(Argument::any())->willThrow(CouldNotMakeHttpGetRequest::class);

        $this->shouldThrow(CouldNotFetchArticleRepositoryException::class)->duringFind(self::ARTICLE_ID);
        $this->shouldThrow(CouldNotFetchArticleRepositoryException::class)->duringFindByIds([]);
    }
}
