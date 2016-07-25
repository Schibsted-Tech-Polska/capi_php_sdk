<?php

namespace Snt\Capi\Repository;

use Exception;
use Snt\Capi\Http\ApiHttpClientInterface;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;

abstract class AbstractRepository
{
    /**
     * @var ApiHttpClientInterface
     */
    protected $httpClient;

    /**
     * @param ApiHttpClientInterface $httpClient
     */
    public function __construct(ApiHttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param FindParametersInterface $findParameters
     *
     * @return mixed
     */
    protected function makeHttpGetRequest(FindParametersInterface $findParameters)
    {
        return $this->httpClient->get(
            $findParameters->buildApiHttpPathAndQuery()
        );
    }

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
