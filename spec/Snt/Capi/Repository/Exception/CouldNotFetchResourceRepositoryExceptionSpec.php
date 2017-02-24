<?php

namespace spec\Snt\Capi\Repository\Exception;

use PhpSpec\ObjectBehavior;
use RuntimeException;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;

/**
 * @mixin CouldNotFetchResourceRepositoryException
 */
class CouldNotFetchResourceRepositoryExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CouldNotFetchResourceRepositoryException::class);
        $this->shouldHaveType(RuntimeException::class);
    }
}
