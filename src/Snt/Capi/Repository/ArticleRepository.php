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
     * @var string
     */
    protected $publicationId;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(
        HttpClientInterface $httpClient
    ) {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $publicationId
     */
    public function setPublicationId($publicationId)
    {
        $this->publicationId = $publicationId;
    }

    /**
     * {@inheritdoc}
     */
    public function find($articleId)
    {
        return $this->fetchArticles([$articleId]);
    }

    /**
     * {@inheritdoc}
     */
    public function findByIds(array $articleIds)
    {
        return $this->fetchArticles($articleIds);
    }

    private function buildPath(array $articleIds)
    {
        return sprintf(self::ARTICLES_PATH_PATTERN, $this->publicationId, implode(',', $articleIds));
    }

    private function fetchArticles(array $articleIds)
    {
        try {
            $articlesRawData = json_decode(
                $this->httpClient->get(
                    $this->buildPath($articleIds)
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
}
