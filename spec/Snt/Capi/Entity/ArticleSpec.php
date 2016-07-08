<?php

namespace spec\Snt\Capi\Entity;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Entity\Article;

/**
 * @mixin Article
 */
class ArticleSpec extends ObjectBehavior
{
    const ARTICLE_ID = '11111';

    const ARTICLE_TITLE = 'title';

    const ARTICLE_STATE = 'published';

    function let()
    {
        $this->beConstructedWith(self::ARTICLE_ID, self::ARTICLE_TITLE, self::ARTICLE_STATE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Article::class);
    }

    function it_returns_article_id()
    {
        $this->getId()->shouldReturn(self::ARTICLE_ID);
    }

    function it_returns_article_title()
    {
        $this->getTitle()->shouldReturn(self::ARTICLE_TITLE);
    }

    function it_returns_article_state()
    {
        $this->getState()->shouldReturn(self::ARTICLE_STATE);
    }
}
