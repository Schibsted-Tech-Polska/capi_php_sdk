<?php

namespace spec\Snt\Capi;

use PhpSpec\ObjectBehavior;
use Snt\Capi\ApiClient;
use Snt\Capi\ApiClientConfiguration;
use Snt\Capi\Repository\ArticleRepositoryInterface;

/**
 * @mixin ApiClient
 */
class ApiClientSpec extends ObjectBehavior
{
    const ENDPOINT = 'endpoint';

    const API_KEY = 'apiKey';

    const API_SECRET = 'apiSecret';

    function let()
    {
        $this->beConstructedWith(new ApiClientConfiguration(self::ENDPOINT, self::API_KEY, self::API_SECRET));
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType(ApiClient::class);
    }

    function it_returns_article_repository_for_publication()
    {
        $this->getArticleRepositoryForPublication('sa')->shouldReturnAnInstanceOf(ArticleRepositoryInterface::class);
    }
}
