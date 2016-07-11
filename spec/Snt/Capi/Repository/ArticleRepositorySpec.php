<?php

namespace spec\Snt\Capi\Repository;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\ArticleRepository;
use Snt\Capi\Repository\ArticleRepositoryInterface;
use Snt\Capi\Entity\Article;

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

        $httpClient->get($path)->willReturn('{"id":123,"title": "some text"}');

        $this->find(self::PUBLICATION_ID, self::ARTICLE_ID)->shouldBeArticleWithRawData([
            'id' => 123,
            'title' => 'some text',
        ]);
    }

    function getMatchers()
    {
        return [
            'beArticleWithRawData' => function (Article $article, array $rawData) {
                return $article->getRawData() === $rawData;
            }
        ];
    }
}
