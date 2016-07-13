<?php

namespace spec\Snt\Capi\Http\Exception;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\Exception\HttpException;
use Snt\Capi\Http\Exception\HttpExceptionReason;

/**
 * @mixin HttpException
 */
class HttpExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(HttpException::class);
    }

    function it_tells_when_exception_is_caused_by_404_error()
    {
        $httpExceptionReason = HttpExceptionReason::createForNotFoundError();

        $this->beConstructedWith('', 0, null, $httpExceptionReason);

        $this->isNotFoundError()->shouldReturn(true);
    }

    function it_tells_when_exception_is_not_caused_by_404_error()
    {
        $this->isNotFoundError()->shouldReturn(false);
    }
}
