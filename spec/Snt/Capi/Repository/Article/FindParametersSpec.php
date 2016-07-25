<?php

namespace spec\Snt\Capi\Repository\Article;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\PublicationId;
use Snt\Capi\Repository\Article\FindParameters;
use Snt\Capi\Repository\FindParametersInterface;

/**
 * @mixin FindParameters
 */
class FindParametersSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FindParameters::class);
        $this->shouldImplement(FindParametersInterface::class);
    }

    function it_creates_find_parameters_for_publication_id_and_article_id()
    {
        $this->beConstructedThrough('createForPublicationIdAndArticleId', [PublicationId::SA, 1]);

        $this->getPublicationId()->shouldReturn(PublicationId::SA);
        $this->getArticleId()->shouldReturn(1);
    }

    function it_builds_api_http_path_and_query()
    {
        $this->beConstructedThrough('createForPublicationIdAndArticleId', [PublicationId::SA, 1]);

        $path = sprintf('publication/%s/articles/%s', PublicationId::SA, '1');

        $expectedApiHttpPathAndQuery = ApiHttpPathAndQuery::createForPath($path);

        $this->buildApiHttpPathAndQuery()->shouldBeLike($expectedApiHttpPathAndQuery);
    }
}
