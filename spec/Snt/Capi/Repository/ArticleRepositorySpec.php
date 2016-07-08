<?php

namespace spec\Snt\Capi\Repository;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Repository\ArticleRepository;
use Snt\Capi\Repository\ArticleRepositoryInterface;
use Snt\Capi\Entity\Article;

/**
 * @mixin ArticleRepository
 */
class ArticleRepositorySpec extends ObjectBehavior
{
    const ARTICLE_ID = '123';

    const PUBLICATION_NAME = 'sa';

    function let()
    {
        $this->beConstructedWith(self::PUBLICATION_NAME);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ArticleRepository::class);
        $this->shouldImplement(ArticleRepositoryInterface::class);
    }

    function it_finds_article_by_its_id()
    {
        $this->find(self::ARTICLE_ID)->shouldBeArticleWithId(self::ARTICLE_ID);
    }

    function getMatchers()
    {
        return [
            'beArticleWithId' => function (Article $article, $id) {
                return $article->getId() === $id;
            }
        ];
    }
}
