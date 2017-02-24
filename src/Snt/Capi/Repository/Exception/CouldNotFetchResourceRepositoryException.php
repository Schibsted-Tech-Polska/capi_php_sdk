<?php

namespace Snt\Capi\Repository\Exception;

use Exception;
use RuntimeException;

class CouldNotFetchResourceRepositoryException extends RuntimeException
{
    /**
     * @param Exception $exception
     *
     * @return self
     */
    public static function createFromPrevious(Exception $exception)
    {
        return new self($exception->getMessage(), $exception->getCode(), $exception);
    }
}
