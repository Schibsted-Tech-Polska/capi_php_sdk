<?php

namespace Snt\Capi\Repository;

use Exception;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;

abstract class AbstractRepository
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param FindParametersInterface $findParameters
     *
     * @return string
     */
    protected function makeHttpGetRequest(FindParametersInterface $findParameters)
    {
        return $this->httpClient->get(
            $findParameters->buildHttpRequestParameters()
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
