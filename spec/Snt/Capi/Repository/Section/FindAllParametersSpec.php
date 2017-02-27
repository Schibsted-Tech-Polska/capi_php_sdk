<?php

namespace spec\Snt\Capi\Repository\Section;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\PublicationId;
use Snt\Capi\Repository\FindParametersInterface;
use Snt\Capi\Repository\Section\FindAllParameters;

/**
 * @mixin FindAllParameters
 */
class FindAllParametersSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThroughCreateForPublicationId(PublicationId::SA);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FindAllParameters::class);
        $this->shouldImplement(FindParametersInterface::class);
    }

    function it_creates_find_parameters_for_publication_id()
    {
        $this->getPublicationId()->shouldReturn(PublicationId::SA);
    }

    function it_builds_api_http_path_and_query()
    {
        $path = sprintf('publication/%s/sections', PublicationId::SA);

        $expectedApiHttpPathAndQuery = ApiHttpPathAndQuery::createForPath($path);

        $this->buildApiHttpPathAndQuery()->shouldBeLike($expectedApiHttpPathAndQuery);
    }
}
