<?php

namespace Snt\Capi\Repository;

use Snt\Capi\Http\ApiHttpClientInterface;
use Snt\Capi\Http\Exception\ApiHttpClientException;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;

abstract class AbstractRepository
{
    protected $httpClient;

    public function __construct(ApiHttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Response
     */
    final protected function fetch(FindParametersInterface $findParameters)
    {
        try {
            $response = $this->decodeJson(
                $this->makeHttpGetRequest($findParameters)
            );

            return Response::createFrom($response);
        } catch (ApiHttpClientException $exception) {
            return Response::createFrom(
                $this->handleExceptionForFindParameters($exception, $findParameters)
            );
        }
    }

    /**
     * @return mixed
     * @throws ApiHttpClientException
     */
    private function makeHttpGetRequest(FindParametersInterface $findParameters)
    {
        return $this->httpClient->get(
            $findParameters->buildApiHttpPathAndQuery()
        );
    }

    /**
     * @param string $string
     *
     * @return mixed
     */
    private function decodeJson($string)
    {
        return json_decode($string, true);
    }

    /**
     * @throws CouldNotFetchResourceRepositoryException
     */
    abstract protected function handleExceptionForFindParameters(
        ApiHttpClientException $exception,
        FindParametersInterface $findParameters
    );
}
