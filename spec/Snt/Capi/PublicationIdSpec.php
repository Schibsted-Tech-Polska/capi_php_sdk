<?php

namespace spec\Snt\Capi;

use PhpSpec\ObjectBehavior;
use Snt\Capi\PublicationId;

/**
 * @mixin PublicationId
 */
class PublicationIdSpec extends ObjectBehavior
{
    const PUBLICATION = 'sa';

    const PERSPECTIVE = 'sport';

    const EXPECTED_PUBLICATION_ID = self::PUBLICATION . ':'. self::PERSPECTIVE;

    function it_is_initializable()
    {
        $this->shouldHaveType(PublicationId::class);
    }
    
    function it_can_be_created_with_perspective()
    {
        $this->beConstructedThroughCreateWithPerspective(self::PUBLICATION, self::PERSPECTIVE);

        $this->get()->shouldReturn(self::EXPECTED_PUBLICATION_ID);
    }
}
