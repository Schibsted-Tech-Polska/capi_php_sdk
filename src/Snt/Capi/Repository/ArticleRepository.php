<?php

namespace Snt\Capi\Repository;

use Snt\Capi\Http\Exception\CouldNotMakeHttpGetRequest;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\Exception\CouldNotFetchArticleRepositoryException;

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
    public function findForPublicationId($publicationId, $articleId)
    {
        return $this->fetchArticlesForPublication($publicationId, [$articleId]);
    }

    /**
     * {@inheritdoc}
     */
    public function findByIdsForPublicationId($publicationId, array $articleIds)
    {
        return $this->fetchArticlesForPublication($publicationId, $articleIds);
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
