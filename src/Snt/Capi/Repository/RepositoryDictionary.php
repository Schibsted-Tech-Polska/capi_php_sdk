<?php

namespace Snt\Capi\Repository;

use Exception;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;

trait RepositoryDictionary
{
    /**
     * @throws CouldNotFetchResourceRepositoryException
     */
    protected function throwCouldNotFetchException(Exception $exception)
    {
        throw CouldNotFetchResourceRepositoryException::createFromPrevious($exception);
    }
}
