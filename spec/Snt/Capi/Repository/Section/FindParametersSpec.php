<?php

namespace spec\Snt\Capi\Repository\Section;

use PhpSpec\ObjectBehavior;
use Snt\Capi\PublicationId;
use Snt\Capi\Repository\Section\FindParameters;

/**
 * @mixin FindParameters
 */
class FindParametersSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FindParameters::class);
    }

    function it_creates_find_parameters_for_publication_id()
    {
        $this->beConstructedThrough('createForPublicationId',[PublicationId::SA]);

        $this->getPublicationId()->shouldReturn(PublicationId::SA);
    }
}
