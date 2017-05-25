<?php

namespace spec\Snt\Capi\Repository\Article;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\PublicationId;
use Snt\Capi\Repository\Article\FindEditorialParameters;
use Snt\Capi\Repository\FindParametersInterface;

/**
 * @mixin FindEditorialParameters
 */
class FindEditorialParametersSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThroughCreateForPublicationIdAndArticleId(PublicationId::SA, 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FindEditorialParameters::class);
        $this->shouldImplement(FindParametersInterface::class);
    }

    function it_creates_find_parameters_for_publication_id_and_article_id()
    {
        $this->getPublicationId()->shouldReturn(PublicationId::SA);
        $this->getArticleId()->shouldReturn(1);
    }

    function it_builds_api_http_path_and_query()
    {
        $path = sprintf('publication/%s/editorials/%s', PublicationId::SA, '1');

        $expectedApiHttpPathAndQuery = ApiHttpPathAndQuery::createForPath($path);

        $this->buildApiHttpPathAndQuery()->shouldBeLike($expectedApiHttpPathAndQuery);
    }
}
