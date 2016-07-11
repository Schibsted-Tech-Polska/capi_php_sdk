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

    function let()
    {
        $this->beConstructedWith(['id' => self::ARTICLE_ID]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Article::class);
    }

    function it_returns_article_raw_data()
    {
        $this->getRawData()->shouldReturn(['id' => self::ARTICLE_ID]);
    }
}
