<?php

namespace spec\Snt\Capi\Http\Exception;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\Exception\HttpExceptionReason;

/**
 * @mixin HttpExceptionReason
 */
class HttpExceptionReasonSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(HttpExceptionReason::class);
    }

    function it_informs_when_it_is_not_found_error()
    {
        $this->beConstructedThrough('createForNotFoundError');

        $this->isNotFoundError()->shouldReturn(true);
    }
}
