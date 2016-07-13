<?php

namespace Snt\Capi\Repository\Article;

use Snt\Capi\Http\Exception\CouldNotMakeHttpGetRequest;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\Article\Exception\CouldNotFetchArticleRepositoryException;

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
        return $this->fetchArticlesForPublication(
            $findParameters->getPublicationId(),
            [
                $findParameters->getArticleId(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findByIds(FindByIdsParameters $findByIdsParameters)
    {
        return $this->fetchArticlesForPublication(
            $findByIdsParameters->getPublicationId(),
            $findByIdsParameters->getArticleIds()
        );
    }

    private function fetchArticlesForPublication($publicationId, array $articleIds)
    {
        try {
            $articlesRawData = json_decode(
                $this->httpClient->get(
                    $this->buildPath($publicationId, $articleIds)
                ),
                true
            );
        } catch (CouldNotMakeHttpGetRequest $exception) {
            throw new CouldNotFetchArticleRepositoryException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return isset($articlesRawData['articles']) ? $articlesRawData['articles'] : $articlesRawData;
    }

    private function buildPath($publicationId, array $articleIds)
    {
        return sprintf(self::ARTICLES_PATH_PATTERN, $publicationId, implode(',', $articleIds));
    }
}
