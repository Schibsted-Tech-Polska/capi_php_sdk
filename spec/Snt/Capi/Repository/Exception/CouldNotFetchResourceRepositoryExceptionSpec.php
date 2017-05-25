<?php

namespace spec\Snt\Capi\Repository\Exception;

use Exception;
use PhpSpec\ObjectBehavior;
use RuntimeException;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;

/**
 * @mixin CouldNotFetchResourceRepositoryException
 */
class CouldNotFetchResourceRepositoryExceptionSpec extends ObjectBehavior
{
    const EXCEPTION_MESSAGE = 'Error';

    const EXCEPTION_CODE = 127;

    function it_is_initializable()
    {
        $this->shouldHaveType(CouldNotFetchResourceRepositoryException::class);
        $this->shouldHaveType(RuntimeException::class);
    }

    function it_creates_itself_from_previous_exception()
    {
        $exception = new Exception(self::EXCEPTION_MESSAGE, self::EXCEPTION_CODE);

        $this->beConstructedThroughCreateFromPrevious($exception);

        $this->getMessage()->shouldReturn(self::EXCEPTION_MESSAGE);
        $this->getCode()->shouldReturn(self::EXCEPTION_CODE);
        $this->getPrevious()->shouldReturn($exception);
    }
}
