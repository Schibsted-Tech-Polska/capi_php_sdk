<?php

namespace spec\Snt\Capi;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Client;
use Snt\Capi\Repository\ArticleRepositoryInterface;

/**
 * @mixin Client
 */
class ClientSpec extends ObjectBehavior
{
    const ENDPOINT = 'endpoint';

    const API_KEY = 'apiKey';

    const API_SECRET = 'apiSecret';

    const PUBLICATION_NAME = 'sa';

    function let()
    {
        $this->beConstructedWith(self::ENDPOINT, self::API_KEY, self::API_SECRET);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
    }

    function it_delivers_data_which_was_used_for_creation()
    {
        $this->getEndpoint()->shouldReturn(self::ENDPOINT);
        $this->getApiKey()->shouldReturn(self::API_KEY);
        $this->getApiSecret()->shouldReturn(self::API_SECRET);
    }

    function it_returns_article_repository()
    {
        $this->getArticleRepository(self::PUBLICATION_NAME)->shouldReturnAnInstanceOf(ArticleRepositoryInterface::class);
    }
}
