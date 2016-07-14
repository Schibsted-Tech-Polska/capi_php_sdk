<?php

namespace spec\Snt\Capi\Repository\Section\Exception;

use RuntimeException;
use PhpSpec\ObjectBehavior;
use Snt\Capi\Repository\Section\Exception\CouldNotFetchSectionRepositoryException;

/**
 * @mixin CouldNotFetchSectionRepositoryException
 */
class CouldNotFetchSectionRepositoryExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CouldNotFetchSectionRepositoryException::class);
        $this->shouldHaveType(RuntimeException::class);
    }
}
