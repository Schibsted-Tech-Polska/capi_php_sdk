<?php

namespace Snt\Capi\Repository\Article;

use Snt\Capi\Http\Exception\HttpException;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;
use Snt\Capi\Repository\FindParametersInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(
        HttpClientInterface $httpClient
    ) {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function find(FindParametersInterface $findParameters)
    {
        try {
            $articleRawData = $this->makeRequest($findParameters);
        } catch (HttpException $exception) {
            if ($exception->isNotFoundError()) {
                return null;
            }

            throw new CouldNotFetchResourceRepositoryException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return $articleRawData;
    }

    /**
     * {@inheritdoc}
     */
    public function findByIds(FindParametersInterface $findParameters)
    {
        try {
            $articlesRawData = $this->makeRequest($findParameters);
        } catch (HttpException $exception) {
            if ($exception->isNotFoundError()) {
                return null;
            }

            throw new CouldNotFetchResourceRepositoryException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return isset($articlesRawData['articles']) ? $articlesRawData['articles'] : [];
    }

    /**
     * {@inheritdoc}
     */
    public function findByChangelog(FindParametersInterface $findParameters)
    {
        try {
            $articlesChangelogRawData = $this->makeRequest($findParameters);
        } catch (HttpException $exception) {
            throw new CouldNotFetchResourceRepositoryException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return $articlesChangelogRawData;
    }

    private function makeRequest(FindParametersInterface $findParameters)
    {
        return json_decode(
            $this->httpClient->get(
                $findParameters->buildHttpRequestParameters()
            ),
            true
        );
    }
}
