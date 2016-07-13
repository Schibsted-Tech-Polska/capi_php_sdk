<?php

namespace spec\Snt\Capi\Repository\Article\Exception;

use PhpSpec\ObjectBehavior;
use RuntimeException;
use Snt\Capi\Repository\Article\Exception\CouldNotFetchArticleRepositoryException;

/**
 * @mixin CouldNotFetchArticleRepositoryException
 */
class CouldNotFetchArticleRepositoryExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CouldNotFetchArticleRepositoryException::class);
        $this->shouldHaveType(RuntimeException::class);
    }
}
