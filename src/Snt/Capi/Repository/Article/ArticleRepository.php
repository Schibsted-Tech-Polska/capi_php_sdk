<?php

namespace Snt\Capi\Repository\Article;

use Snt\Capi\Http\Exception\HttpException;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;

class ArticleRepository implements ArticleRepositoryInterface
{
    const ARTICLES_PATH_PATTERN = 'publication/%s/articles/%s';

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
    public function find(FindParameters $findParameters)
    {
        return $this->fetchArticlesForPublication($findParameters);
    }

    /**
     * {@inheritdoc}
     */
    public function findByIds(FindParameters $findParameters)
    {
        return $this->fetchArticlesForPublication($findParameters);
    }

    private function fetchArticlesForPublication(FindParameters $findParameters)
    {
        try {
            $articlesRawData = json_decode(
                $this->httpClient->get(
                    $this->buildPath($findParameters)
                ),
                true
            );
        } catch (HttpException $exception) {
            if ($this->returnNull($findParameters, $exception)) {
                return null;
            }

            throw new CouldNotFetchResourceRepositoryException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return isset($articlesRawData['articles']) ? $articlesRawData['articles'] : $articlesRawData;
    }

    private function buildPath(FindParameters $findParameters)
    {
        return sprintf(
            self::ARTICLES_PATH_PATTERN,
            $findParameters->getPublicationId(),
            $findParameters->buildArticleIdsString()
        );
    }

    private function returnNull(FindParameters $findParameters, HttpException $exception)
    {
        return $findParameters->hasArticleId() && $exception->isNotFoundError();
    }
}
