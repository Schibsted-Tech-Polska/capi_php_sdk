<?php

namespace Snt\Capi\Repository;

use Exception;
use Snt\Capi\Http\ApiHttpClientInterface;
use Snt\Capi\Http\Exception\ApiHttpClientException;
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
     * @param FindParametersInterface $findParameters
     *
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
     * @param ApiHttpClientException $exception
     * @param FindParametersInterface $findParameters
     *
     * @throws CouldNotFetchResourceRepositoryException
     */
    abstract protected function handleExceptionForFindParameters(
        ApiHttpClientException $exception,
        FindParametersInterface $findParameters
    );
}
