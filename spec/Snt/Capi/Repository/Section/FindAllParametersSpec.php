<?php

namespace spec\Snt\Capi\Repository\Section;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\HttpRequestParameters;
use Snt\Capi\PublicationId;
use Snt\Capi\Repository\FindParametersInterface;
use Snt\Capi\Repository\Section\FindAllParameters;

/**
 * @mixin FindAllParameters
 */
class FindAllParametersSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FindAllParameters::class);
        $this->shouldImplement(FindParametersInterface::class);
    }

    function it_creates_find_parameters_for_publication_id()
    {
        $this->beConstructedThrough('createForPublicationId',[PublicationId::SA]);

        $this->getPublicationId()->shouldReturn(PublicationId::SA);
    }

    function it_builds_http_request_parameters()
    {
        $this->beConstructedThrough('createForPublicationId',[PublicationId::SA]);

        $path = sprintf('publication/%s/sections', PublicationId::SA);

        $expectedHttpRequestParameters = HttpRequestParameters::createForPath($path);

        $this->buildHttpRequestParameters()->shouldBeLike($expectedHttpRequestParameters);
    }
}
