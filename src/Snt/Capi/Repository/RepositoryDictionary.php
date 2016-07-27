<?php

namespace Snt\Capi\Repository;

use Exception;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;

trait RepositoryDictionary
{
    /**
     * @param Exception $exception
     *
     * @throws CouldNotFetchResourceRepositoryException
     */
    protected function throwCouldNotFetchException(Exception $exception)
    {
        throw new CouldNotFetchResourceRepositoryException(
            $exception->getMessage(),
            $exception->getCode(),
            $exception
        );
    }
}
